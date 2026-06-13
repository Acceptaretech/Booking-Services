<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HandymanCommission extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'commission',
        'type',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}