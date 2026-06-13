<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\CustomerAddressServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;

class CustomerAddressApiController extends Controller
{
    protected CustomerAddressServiceInterface $addressService;

    public function __construct(CustomerAddressServiceInterface $addressService)
    {
        $this->addressService = $addressService;
    }

    public function index(Request $request)
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Addresses fetched successfully',
                'data' => $this->addressService->index($request->user())
            ]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Address added successfully',
                'data' => $this->addressService->store($request->user(), $request)
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

    public function update(Request $request, $addressId)
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Address updated successfully',
                'data' => $this->addressService->update($request->user(), $request, $addressId)
            ]);
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

    public function destroy(Request $request, $addressId)
    {
        try {
            $this->addressService->delete($request->user(), $addressId);

            return response()->json([
                'success' => true,
                'message' => 'Address deleted successfully'
            ]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function makeDefault(Request $request, $addressId)
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Default address updated successfully',
                'data' => $this->addressService->makeDefault($request->user(), $addressId)
            ]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}