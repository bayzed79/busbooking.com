# Refund System Implementation

## Overview
A simple refund system that uses the existing "Cancel" button in Purchase History to initiate refund requests based on time-based policies.

## Refund Policy
- **More than 4 hours before trip**: 100% refund
- **2-4 hours before trip**: 50% refund  
- **Less than 2 hours before trip**: No refund

## User-Side Flow

### 1. Cancel Click
- User clicks the existing "Cancel" button in Purchase History
- System shows refund policy page with calculated refund amount

### 2. Refund Policy Display
- Shows trip details and booking information
- Displays refund policy based on time until trip
- Shows calculated refund amount
- Shows hours until trip departure

### 3. Confirm Cancellation
- If refund is available, user can confirm cancellation
- System updates order status from "Processing" to "Refunding"
- Seats are automatically released (marked as available)

### 4. UI Status Changes
- Cancel button changes to "Refunding" badge
- After admin confirmation, shows "Refunded" badge

## Admin-Side Flow

### 1. Dashboard Counter
- Admin dashboard shows "Refund Requests (N)" count
- N = count of orders with status = "Refunding"

### 2. Refund Requests Table
- Lists all orders with "Refunding" status
- Shows Order ID, Customer details, Trip details, Refund amount
- Toggle switch for "Confirm Refund"

### 3. Confirm Refunds
- Admin toggles switch to confirm refund
- System updates order status from "Refunding" to "Refunded"
- Row is removed from table with success animation

## Database Changes
- Uses existing `orders` table
- Uses existing `buses` table
- No new tables or modifications required

## Files Modified

### Models
- `Order.php` - Added refund calculation methods

### Controllers
- `RefundController.php` - Complete refund logic

### Views
- `refund/policy.blade.php` - Refund policy page
- `admin/refund_requests.blade.php` - Admin management
- `purchase_history.blade.php` - Modified Cancel button
- `admin/dashboard.blade.php` - Added refund count

### Routes
- User refund routes
- Admin refund routes

## Key Features
- ✅ Uses existing Cancel button
- ✅ Time-based refund calculation
- ✅ Automatic seat management
- ✅ Admin toggle confirmation
- ✅ Real-time status updates
- ✅ No database modifications
- ✅ Simple and efficient

## Routes
```
GET /refund/policy/{orderId} - Show refund policy
POST /refund/process/{orderId} - Process refund
GET /admin/refund-requests - Admin refund requests
POST /admin/refund/confirm/{orderId} - Confirm refund
```

The refund system is now ready to use! 🚀 