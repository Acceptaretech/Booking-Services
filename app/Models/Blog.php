<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'author_id',
        'title',
        'content',
        'image',
        'slug',
        'meta_title',
        'meta_description',
        'read_time',
        'views',
        'status',
        'published_at'
    ];
    protected $casts = [
        'published_at' => 'datetime',
    ];
    public function author()
    {
        return $this->belongsTo(User::class,'author_id');
    }
}