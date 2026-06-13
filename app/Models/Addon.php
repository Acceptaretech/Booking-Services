<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Addon extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'service_id',
        'name',
        'price',
        'image',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function provider()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function getImageUrlAttribute()
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('images/default-service.png');
    }
}