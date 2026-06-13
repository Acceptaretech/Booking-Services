<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'name',
        'document_type',
        'is_required',
        'status',
    ];

    protected $casts = [
        'is_required' => 'boolean',
    ];
}