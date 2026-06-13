<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\CustomerBookingServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;

class CustomerBookingApiController extends Controller
{
    protected CustomerBookingServiceInterface $bookingService;

    public function __construct(CustomerBookingServiceInterface $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index(Request $request)
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Bookings fetched successfully',
                'data' => $this->bookingService->index($request->user(), $request)
            ]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request, $serviceId)
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Booking created successfully',
                'data' => $this->bookingService->store($request->user(), $request, $serviceId)
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => collect($e->errors())->flatten()->first(),
                'errors' => $e->errors()
            ], 422);

        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function show(Request $request, $bookingId)
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Booking detail fetched successfully',
                'data' => $this->bookingService->show($request->user(), $bookingId)
            ]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}