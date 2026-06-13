<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'registration_number',
        'email',
        'phone',
        'country_code',
        'address',
        'country',
        'state',
        'city',
        'latitude',
        'longitude',
        'image',
        'status',
        'languages',
    ];

    protected $casts = [
        'languages' => 'array',
        'latitude'  => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function provider()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getImageUrlAttribute()
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('images/default-service.png');
    }
}