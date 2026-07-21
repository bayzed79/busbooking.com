<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeatSwap extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_id',
        'requester_id',
        'requester_order_id',
        'requester_seat',
        'target_user_id',
        'target_order_id',
        'target_seat',
        'status'
    ];

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function targetUser()
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }

    public function requesterOrder()
    {
        return $this->belongsTo(Order::class, 'requester_order_id');
    }

    public function targetOrder()
    {
        return $this->belongsTo(Order::class, 'target_order_id');
    }
}
