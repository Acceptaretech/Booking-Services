<?php

namespace App\Services;

use App\Models\{Booking, BookingStatusLog, CommissionSetting, Coupon, Payment, Service, Tax, WalletTransaction};
use Illuminate\Support\Facades\DB;

class BookingService
{
    /**
     * Calculate booking price breakdown.
     */
    public function calculatePrice(
        Service $service,
        int $quantity,
        ?string $couponCode,
        ?int $packageId = null
    ): array {
        $basePrice     = $service->discounted_price * $quantity;
        $discountAmt   = ($service->price - $service->discounted_price) * $quantity;
        $couponDiscount = 0;
        $coupon        = null;

        if ($couponCode) {
            $coupon = Coupon::where('code', $couponCode)
                ->where('status', 'active')
                ->where(function ($q) {
                    $q->whereNull('end_date')->orWhere('end_date', '>=', now()->toDateString());
                })->first();

            if ($coupon && $basePrice >= $coupon->min_amount) {
                if ($coupon->discount_type === 'percent') {
                    $couponDiscount = $basePrice * $coupon->discount / 100;
                    if ($coupon->max_discount) {
                        $couponDiscount = min($couponDiscount, $coupon->max_discount);
                    }
                } else {
                    $couponDiscount = $coupon->discount;
                }
            }
        }

        $subtotal = $basePrice - $couponDiscount;

        // Tax
        $tax = Tax::where('status', 'active')->first();
        $taxAmount = 0;
        if ($tax) {
            $taxAmount = $tax->type === 'percent'
                ? $subtotal * $tax->value / 100
                : $tax->value;
        }

        $total = $subtotal + $taxAmount;

        return [
            'base_price'      => $service->price * $quantity,
            'discount_amount' => $discountAmt,
            'coupon_discount' => $couponDiscount,
            'coupon'          => $coupon,
            'tax_amount'      => round($taxAmount, 2),
            'total_amount'    => round($total, 2),
            'subtotal'        => round($subtotal, 2),
        ];
    }

    /**
     * Create a booking and associated payment record.
     */
    public function createBooking(array $data): Booking
    {
        return DB::transaction(function () use ($data) {
            $booking = Booking::create([
                'booking_number' => Booking::generateNumber(),
                'customer_id'    => $data['customer_id'],
                'service_id'     => $data['service_id'],
                'provider_id'    => $data['provider_id'],
                'shop_id'        => $data['shop_id'] ?? null,
                'coupon_id'      => $data['coupon_id'] ?? null,
                'addons'         => $data['addons'] ?? null,
                'base_price'     => $data['base_price'],
                'discount_amount'=> $data['discount_amount'],
                'coupon_discount'=> $data['coupon_discount'],
                'tax_amount'     => $data['tax_amount'],
                'total_amount'   => $data['total_amount'],
                'quantity'       => $data['quantity'],
                'address'        => $data['address'],
                'latitude'       => $data['latitude'] ?? null,
                'longitude'      => $data['longitude'] ?? null,
                'booking_date'   => $data['booking_date'],
                'notes'          => $data['notes'] ?? null,
                'status'         => 'pending',
                'payment_status' => 'pending',
                'payment_type'   => $data['payment_type'] ?? 'cash',
            ]);

            // Log initial status
            BookingStatusLog::create([
                'booking_id'  => $booking->id,
                'changed_by'  => $data['customer_id'],
                'old_status'  => null,
                'new_status'  => 'pending',
                'notes'       => 'Booking created',
            ]);

            // Update coupon usage
            if (!empty($data['coupon_id'])) {
                Coupon::where('id', $data['coupon_id'])->increment('used_count');
            }

            // Update service booking count
            Service::where('id', $data['service_id'])->increment('total_bookings');

            return $booking;
        });
    }

    /**
     * Update booking status with log.
     */
    public function updateStatus(Booking $booking, string $newStatus, int $changedBy, ?string $notes = null): Booking
    {
        $oldStatus = $booking->status;

        DB::transaction(function () use ($booking, $newStatus, $changedBy, $notes, $oldStatus) {
            $booking->update(['status' => $newStatus]);

            BookingStatusLog::create([
                'booking_id'  => $booking->id,
                'changed_by'  => $changedBy,
                'old_status'  => $oldStatus,
                'new_status'  => $newStatus,
                'notes'       => $notes,
            ]);

            // If completed → calculate commissions
            if ($newStatus === 'completed' && $booking->payment_status !== 'paid') {
                $this->processPayment($booking);
            }
        });

        return $booking->fresh();
    }

    /**
     * Process commission split after completion.
     */
    public function processPayment(Booking $booking): void
    {
        $commissionSetting = CommissionSetting::where('provider_id', $booking->provider_id)->first()
            ?? CommissionSetting::whereNull('provider_id')->first();

        $totalAmount     = $booking->total_amount;
        $adminCommission = 0;
        $providerEarning = $totalAmount;

        if ($commissionSetting) {
            $adminCommission = $commissionSetting->commission_type === 'percent'
                ? $totalAmount * $commissionSetting->commission_value / 100
                : $commissionSetting->commission_value;
            $providerEarning = $totalAmount - $adminCommission;
        }

        // Handyman commission from provider share
        $handymanEarning = 0;
        if ($booking->handyman_id) {
            $handymanCommission = \App\Models\HandymanCommission::where('user_id', $booking->provider_id)
                ->where('status', 'active')->first();
            if ($handymanCommission) {
                $handymanEarning = $handymanCommission->type === 'percent'
                    ? $providerEarning * $handymanCommission->commission / 100
                    : $handymanCommission->commission;
                $providerEarning -= $handymanEarning;
            }
        }

        Payment::updateOrCreate(
            ['booking_id' => $booking->id],
            [
                'customer_id'       => $booking->customer_id,
                'provider_id'       => $booking->provider_id,
                'handyman_id'       => $booking->handyman_id,
                'amount'            => $totalAmount,
                'admin_commission'  => round($adminCommission, 2),
                'provider_earning'  => round($providerEarning, 2),
                'handyman_earning'  => round($handymanEarning, 2),
                'tax'               => $booking->tax_amount,
                'type'              => $booking->payment_type ?? 'cash',
                'status'            => 'paid',
            ]
        );

        // Credit provider wallet
        $booking->provider->increment('wallet_amount', round($providerEarning, 2));
        WalletTransaction::create([
            'user_id'      => $booking->provider_id,
            'amount'       => round($providerEarning, 2),
            'type'         => 'credit',
            'description'  => "Booking #{$booking->booking_number} completed",
            'reference_id' => $booking->id,
        ]);

        // Credit handyman wallet
        if ($booking->handyman_id && $handymanEarning > 0) {
            $booking->handyman->increment('wallet_amount', round($handymanEarning, 2));
            WalletTransaction::create([
                'user_id'      => $booking->handyman_id,
                'amount'       => round($handymanEarning, 2),
                'type'         => 'credit',
                'description'  => "Booking #{$booking->booking_number} - handyman earning",
                'reference_id' => $booking->id,
            ]);
        }

        $booking->update(['payment_status' => 'paid', 'paid_amount' => $totalAmount]);
    }
}
