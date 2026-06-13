<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'booking_number','customer_id','service_id','provider_id','handyman_id',
        'shop_id','coupon_id','package_id','addons','base_price','discount_amount',
        'coupon_discount','tax_amount','total_amount','paid_amount','quantity',
        'address','latitude','longitude','booking_date','notes','status',
        'payment_status','payment_type','transaction_id',
    ];
    protected $casts = [
        'addons'=>'array','booking_date'=>'datetime',
        'base_price'=>'decimal:2','total_amount'=>'decimal:2',
        'paid_amount'=>'decimal:2',
    ];

    public static function generateNumber(): string
    {
        return 'BK-'.strtoupper(uniqid());
    }

    public function customer()  { return $this->belongsTo(User::class,'customer_id'); }
    public function provider()  { return $this->belongsTo(User::class,'provider_id'); }
    public function handyman()  { return $this->belongsTo(User::class,'handyman_id'); }
    public function service()   { return $this->belongsTo(Service::class); }
    public function shop()      { return $this->belongsTo(Shop::class); }
    public function coupon()    { return $this->belongsTo(Coupon::class); }
    public function package()   { return $this->belongsTo(Package::class); }
    public function statusLogs(){ return $this->hasMany(BookingStatusLog::class); }
    public function payment()   { return $this->hasOne(Payment::class); }
    public function review()    { return $this->hasOne(Review::class); }

    public function scopePending($q)   { return $q->where('status','pending'); }
    public function scopeCompleted($q) { return $q->where('status','completed'); }
    public function scopeActive($q)    { return $q->whereNotIn('status',['completed','cancelled','rejected']); }

    
}
