<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'sub_category_id',
        'service_id',
        'name',
        'description',
        'image',
        'package_type',
        'price',
        'original_price',
        'start_at',
        'end_at',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'start_at' => 'date',
        'end_at' => 'date',
    ];

    /**
     * Provider
     */
    public function provider()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Sub Category
     */
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    /**
     * Service
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Package Image URL
     */
    public function getImageUrlAttribute()
    {
        if ($this->image && file_exists(public_path('storage/' . $this->image))) {
            return asset('storage/' . $this->image);
        }

        return asset('images/default-service.png');
    }

    /**
     * Discount Amount
     */
    public function getDiscountAmountAttribute()
    {
        if (!$this->original_price || $this->original_price <= $this->price) {
            return 0;
        }

        return $this->original_price - $this->price;
    }

    /**
     * Discount Percentage
     */
    public function getDiscountPercentAttribute()
    {
        if (!$this->original_price || $this->original_price <= 0) {
            return 0;
        }

        return round(
            (($this->original_price - $this->price) / $this->original_price) * 100
        );
    }

    /**
     * Active Scope
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}