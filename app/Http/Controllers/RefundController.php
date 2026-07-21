<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Bus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RefundController extends Controller
{
    // Show refund policy modal when cancel is clicked
    public function showRefundPolicy($orderId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to access refund policy.');
        }

        $order = Order::findOrFail($orderId);
        
        // Check if user owns this order
        if ($order->email !== Auth::user()->email) {
            return redirect()->route('purchase_history')->with('error', 'Unauthorized access');
        }

        $refundAmount = $order->calculateRefundAmount();
        $refundPolicy = $order->getRefundPolicy();
        $hoursUntilTrip = $order->getHoursUntilTrip();

        return view('refund.policy', compact('order', 'refundAmount', 'refundPolicy', 'hoursUntilTrip'));
    }

    // Process refund when user confirms
    public function processRefund(Request $request, $orderId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to process refund.');
        }

        $order = Order::findOrFail($orderId);
        
        // Check if user owns this order
        if ($order->email !== Auth::user()->email) {
            return redirect()->route('purchase_history')->with('error', 'Unauthorized access');
        }

        // Check if refund is possible
        if (!$order->canRefund()) {
            return redirect()->back()->with('error', 'Refund not available for this booking');
        }

        try {
            DB::beginTransaction();

            // Update order status to Refunding
            $order->update([
                'status' => 'Refunding',
                'refund_amount' => $order->calculateRefundAmount(),
                'refund_requested_at' => now()
            ]);

            // Update bus seats - release them
            $this->releaseSeats($order);

            DB::commit();

            return redirect()->route('purchase_history')->with('success', 'Refund request submitted successfully');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to submit refund request');
        }
    }

    // Release seats when refund is requested
    private function releaseSeats($order)
    {
        $bus = Bus::find($order->bus_id);
        if (!$bus) return;

        $ticketlist = json_decode($order->ticketlist, true);
        if (!is_array($ticketlist)) return;

        $view = $bus->view;
        $seatsAvailable = $bus->seats_available;

        foreach ($ticketlist as $seatName) {
            $seatPosition = $this->getSeatPosition($seatName, $view);
            if ($seatPosition !== false) {
                $view[$seatPosition] = '0'; // Mark as available
                $seatsAvailable++;
            }
        }

        $bus->update([
            'view' => $view,
            'seats_available' => $seatsAvailable
        ]);
    }

    // Get seat position in view string
    private function getSeatPosition($seatName, $view)
    {
        $seatMap = [];
        $position = 0;
        
        // Generate seat map (A1, A2, A3, A4, B1, B2, etc.)
        for ($row = 'A'; $row <= 'Z'; $row++) {
            for ($col = 1; $col <= 4; $col++) {
                $seatMap[$row . $col] = $position;
                $position++;
                if ($position >= strlen($view)) {
                    break 2;
                }
            }
        }

        return isset($seatMap[$seatName]) ? $seatMap[$seatName] : false;
    }

    // Admin: Show refund requests
    public function adminRefundRequests()
    {
        $refundRequests = Order::where('status', 'Refunding')
            ->orderBy('refund_requested_at', 'desc')
            ->paginate(15);

        $totalRequests = Order::where('status', 'Refunding')->count();

        return view('admin.refund_requests', compact('refundRequests', 'totalRequests'));
    }

    // Admin: Confirm refund
    public function confirmRefund(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        
        if ($order->status !== 'Refunding') {
            return response()->json(['success' => false, 'message' => 'Invalid refund status']);
        }

        try {
            $order->update([
                'status' => 'Refunded',
                'refund_processed_at' => now()
            ]);

            return response()->json(['success' => true, 'message' => 'Refund confirmed successfully']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to confirm refund']);
        }
    }
}
