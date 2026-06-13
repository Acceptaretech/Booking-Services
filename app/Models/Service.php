<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'sub_category_id',
        'zone_id',
        'shop_id',
        'name',
        'description',
        'image',
        'gallery',
        'price',
        'discount',
        'price_type',
        'duration',
        'type',
        'available_locations',
        'is_featured',
        'status',
        'avg_rating',
        'total_reviews',
        'total_bookings',
    ];

    protected $casts = [
        'gallery'             => 'array',
        'available_locations' => 'array',
        'is_featured'         => 'boolean',
        'price'               => 'decimal:2',
        'discount'            => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getImageUrlAttribute()
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('images/default-service.png');
    }

    public function getDiscountedPriceAttribute()
    {
        return $this->price - (($this->price * $this->discount) / 100);
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function provider()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    public function faqs()
    {
        return $this->hasMany(ServiceFaq::class);
    }

    public function addons()
    {
        return $this->hasMany(Addon::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeTopRated($query)
    {
        return $query->orderByDesc('avg_rating');
    }

    public function scopeBestSelling($query)
    {
        return $query->orderByDesc('total_bookings');
    }
}