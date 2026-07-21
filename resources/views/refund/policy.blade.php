@extends('mainlayout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-undo-alt me-2"></i>Refund Policy
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Trip Information -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Trip Details</h6>
                            @php
                                $bus = App\Models\Bus::find($order->bus_id);
                            @endphp
                            <p class="mb-1"><strong>Bus:</strong> {{ $bus->bus_name }}</p>
                            <p class="mb-1"><strong>Route:</strong> {{ $bus->starting_point }} → {{ $bus->ending_point }}</p>
                            <p class="mb-1"><strong>Date:</strong> {{ \Carbon\Carbon::parse($bus->date)->format('M d, Y') }}</p>
                            <p class="mb-1"><strong>Time:</strong> {{ $bus->departing_time }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Booking Details</h6>
                            <p class="mb-1"><strong>Transaction ID:</strong> {{ $order->transaction_id }}</p>
                            <p class="mb-1"><strong>Amount Paid:</strong> ৳{{ number_format($order->amount, 2) }}</p>
                            <p class="mb-1"><strong>Hours until trip:</strong> {{ $hoursUntilTrip }} hours</p>
                        </div>
                    </div>

                    <hr>

                    <!-- Refund Policy -->
                    <div class="alert alert-info">
                        <h6 class="alert-heading">
                            <i class="fas fa-info-circle me-2"></i>Refund Policy
                        </h6>
                        <p class="mb-0">{{ $refundPolicy }}</p>
                    </div>

                    <!-- Refund Amount -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h5 class="text-primary">৳{{ number_format($refundAmount, 2) }}</h5>
                                    <small class="text-muted">Refund Amount</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h5 class="text-info">{{ $hoursUntilTrip }} hours</h5>
                                    <small class="text-muted">Time until trip</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($refundAmount > 0)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Important:</strong> Once you confirm this cancellation, your seats will be released and made available to other passengers.
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('purchase_history') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back
                            </a>
                            <form action="{{ route('refund.process', $order->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-check me-2"></i>Confirm Cancellation
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="text-center">
                            <div class="alert alert-danger">
                                <i class="fas fa-times-circle me-2"></i>
                                <strong>No Refund Available</strong><br>
                                Refunds are not available for trips departing within 2 hours.
                            </div>
                            <a href="{{ route('purchase_history') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Purchase History
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 