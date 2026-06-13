<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\CustomerAuthServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;

class CustomerAuthApiController extends Controller
{
    protected CustomerAuthServiceInterface $customerAuthService;

    public function __construct(CustomerAuthServiceInterface $customerAuthService)
    {
        $this->customerAuthService = $customerAuthService;
    }

    public function register(Request $request)
    {
        try {

            $data = $this->customerAuthService->register($request);

            return response()->json([
                'success' => true,
                'message' => 'Customer registered successfully',
                'data' => $data
            ], 201);

        } catch (ValidationException $e) {

            return response()->json([
                'success' => false,
                'message' => collect($e->errors())->flatten()->first(),
                'errors' => $e->errors()
            ], 422);

        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {

            $data = $this->customerAuthService->login($request);

            if (isset($data['error'])) {
                return response()->json([
                    'success' => false,
                    'message' => $data['message']
                ], $data['status']);
            }

            return response()->json([
                'success' => true,
                'message' => 'Customer login successful',
                'data' => $data
            ]);

        } catch (ValidationException $e) {

            return response()->json([
                'success' => false,
                'message' => collect($e->errors())->flatten()->first(),
                'errors' => $e->errors()
            ], 422);

        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {

            $this->customerAuthService->logout($request);

            return response()->json([
                'success' => true,
                'message' => 'Customer logout successful'
            ]);

        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}