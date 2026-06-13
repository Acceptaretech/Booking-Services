<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Handyman extends Model
{
    protected $fillable = [
        'user_id',
        'provider_id',
        'commission',
        'commission_type',
        'country',
        'state',
        'city',
        'address',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }
}