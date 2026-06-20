<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'username','first_name','last_name','email','phone','country_code',
        'password','role','provider_id','category_id','commission_type',
        'commission','designation','profile_image','address',
        'country','state','city','zone_id','wallet_amount','status',
        'is_verified','otp','otp_expires_at',
    ];

    protected $hidden = ['password','remember_token','otp'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_expires_at'    => 'datetime',
        'is_verified'       => 'boolean',
        'wallet_amount'     => 'decimal:2',
    ];

    // ── Helpers ────────────────────────────────────────────────
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getProfileImageUrlAttribute(): string
    {
        return $this->profile_image
            ? asset('storage/' . $this->profile_image)
            : asset('images/default-avatar.png');
    }

    public function isAdmin(): bool    { return $this->role === 'admin'; }
    public function isProvider(): bool { return $this->role === 'provider'; }
    public function isHandyman(): bool { return $this->role === 'handyman'; }
    public function isCustomer(): bool { return $this->role === 'customer'; }
    public function isActive(): bool   { return $this->status === 'active'; }

    // ── Relationships ──────────────────────────────────────────
    public function zone()         { return $this->belongsTo(Zone::class); }
    public function document()     { return $this->hasOne(UserDocument::class); }
    public function shops()        { return $this->hasMany(Shop::class); }
    public function services()     { return $this->hasMany(Service::class); }
    public function packages()     { return $this->hasMany(Package::class); }
    public function addons()       { return $this->hasMany(Addon::class); }
    public function commissions()  { return $this->hasMany(HandymanCommission::class); }

    // As customer
    public function customerBookings()
    {
        return $this->hasMany(Booking::class, 'customer_id');
    }

    // As provider
    public function providerBookings()
    {
        return $this->hasMany(Booking::class, 'provider_id');
    }

    // As handyman
    public function handymanBookings()
    {
        return $this->hasMany(Booking::class, 'handyman_id');
    }

    // // Provider's handymen
    // public function handymen()
    // {
    //     return $this->hasMany(User::class, 'zone_id', 'zone_id')
    //                 ->where('role', 'handyman');
    // }

    // Provider → Handymen
    public function handymen()
    {
        return $this->hasMany(User::class, 'provider_id')
                    ->where('role', 'handyman');
    }

    // Handyman → Provider
    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'provider_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'provider_id');
    }

    public function walletTransactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function withdrawalRequests()
    {
        return $this->hasMany(WithdrawalRequest::class);
    }

    public function commissionSetting()
    {
        return $this->hasOne(CommissionSetting::class, 'provider_id');
    }

    public function promotionalBanners()
    {
        return $this->hasMany(PromotionalBanner::class);
    }

    public function helpDesks()
    {
        return $this->hasMany(HelpDesk::class);
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'author_id');
    }

    // ── Scopes ────────────────────────────────────────────────
    public function scopeActive($q)    { return $q->where('status', 'active'); }
    public function scopeProviders($q) { return $q->where('role', 'provider'); }
    public function scopeHandymen($q)  { return $q->where('role', 'handyman'); }
    public function scopeCustomers($q) { return $q->where('role', 'customer'); }

    public function handyman()
    {
        return $this->hasOne(\App\Models\Handyman::class);
    }

    public function providerHandymen()
    {
        return $this->hasMany(\App\Models\Handyman::class, 'provider_id');
    }
    public function commission()
    {
        return $this->belongsTo(\App\Models\HandymanCommission::class, 'commission_id');
    }
}
