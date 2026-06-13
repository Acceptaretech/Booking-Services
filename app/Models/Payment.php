<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'booking_id',
        'customer_id',
        'provider_id',
        'handyman_id',
        'transaction_id',
        'amount',
        'admin_commission',
        'provider_earning',
        'handyman_earning',
        'tax',
        'type',
        'status',
        'payment_data',
    ];

    protected $casts = [
        'payment_data' => 'array',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function handyman()
    {
        return $this->belongsTo(User::class, 'handyman_id');
    }
}