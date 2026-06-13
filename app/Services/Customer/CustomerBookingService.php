<?php

namespace App\Services\Customer;

use App\Models\Booking;
use App\Models\Service;
use App\Services\Interfaces\CustomerBookingServiceInterface;
use Illuminate\Http\Request;
use Exception;

class CustomerBookingService implements CustomerBookingServiceInterface
{
    public function index($user, Request $request)
    {
        try {
            $bookings = Booking::with(['service', 'provider'])
                ->where('customer_id', $user->id)
                ->when($request->status, fn ($q) => $q->where('status', $request->status))
                ->latest()
                ->paginate($request->per_page ?? 10);

            $bookings->getCollection()->transform(function ($booking) {
                return [
                    'id'             => $booking->id,
                    'service_name'   => $booking->service?->name,
                    'service_image'  => $booking->service?->image
                        ? asset('storage/' . $booking->service->image)
                        : null,
                    'provider_name'  => $booking->provider
                        ? trim($booking->provider->first_name . ' ' . $booking->provider->last_name)
                        : null,
                    'booking_number' => $booking->booking_number,
                    'booking_date'   => $booking->booking_date,
                    'status'         => ucfirst($booking->status),
                    'amount'         => number_format((float) $booking->total_amount, 2, '.', ''),
                ];
            });

            return $bookings;

        } catch (Exception $e) {
            throw $e;
        }
    }

    public function store($user, Request $request, $serviceId)
    {
        try {
            $data = $request->validate([
                'booking_date' => 'required|date',
                'address'      => 'required|string|max:500',
                'note'         => 'nullable|string',
            ]);

            $service = Service::findOrFail($serviceId);

            $basePrice = $service->price ?? 0;
            $discount = $service->discount ?? 0;
            $totalAmount = $basePrice - $discount;

            return Booking::create([
                'booking_number' => 'BK-' . now()->format('YmdHis') . '-' . rand(1000, 9999),
                'customer_id'    => $user->id,
                'service_id'     => $service->id,
                'provider_id'    => $service->user_id ?? null,
                'booking_date'   => $data['booking_date'],
                'address'        => $data['address'],
                'note'           => $data['note'] ?? null,
                'base_price'     => $basePrice,
                'discount'       => $discount,
                'total_amount'   => $totalAmount,
                'status'         => 'pending',
            ]);

        } catch (Exception $e) {
            throw $e;
        }
    }

    public function show($user, $bookingId)
    {
        try {
            $booking = Booking::with(['service', 'provider'])
                ->where('customer_id', $user->id)
                ->findOrFail($bookingId);
    
            return [
                'id'             => $booking->id,
                'service_name'   => $booking->service?->name,
                'service_image'  => $booking->service?->image
                    ? asset('storage/' . $booking->service->image)
                    : null,
                'provider_name'  => $booking->provider
                    ? trim($booking->provider->first_name . ' ' . $booking->provider->last_name)
                    : null,
                'booking_number' => $booking->booking_number,
                'booking_date'   => $booking->booking_date,
                'address'        => $booking->address,
                'note'           => $booking->note,
                'base_price'     => number_format((float) $booking->base_price, 2, '.', ''),
                'discount'       => number_format((float) $booking->discount, 2, '.', ''),
                'amount'         => number_format((float) $booking->total_amount, 2, '.', ''),
                'status'         => ucfirst($booking->status),
            ];
    
        } catch (Exception $e) {
            throw $e;
        }
    }
}