<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $guarded = ['id'];

    /**
     * Users in this zone
     */
    public function users()
    {
        return $this->hasMany(User::class, 'zone_id');
    }

    /**
     * Providers in this zone
     */
    public function providers()
    {
        return $this->hasMany(User::class, 'zone_id')
                    ->where('role', 'provider');
    }

    /**
     * Services in this zone
     */
    public function services()
    {
        return $this->hasMany(Service::class, 'zone_id');
    }

    /**
     * Active zones scope
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}