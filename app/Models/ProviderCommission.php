<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProviderCommission extends Model
{
    protected $fillable = [
        'name',
        'commission',
        'type',
        'status',
    ];
}
