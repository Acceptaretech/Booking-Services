<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\CustomerProfileServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;

class CustomerProfileApiController extends Controller
{
    protected CustomerProfileServiceInterface $profileService;

    public function __construct(CustomerProfileServiceInterface $profileService)
    {
        $this->profileService = $profileService;
    }

    public function profile(Request $request)
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Profile fetched successfully',
                'data' => $this->profileService->profile($request->user())
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $data = $this->profileService->update($request, $request->user());

            if (is_array($data) && isset($data['error'])) {
                return response()->json([
                    'success' => false,
                    'message' => $data['message']
                ], $data['status']);
            }

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
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
}