<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\CustomerWalletServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;

class CustomerWalletApiController extends Controller
{
    protected CustomerWalletServiceInterface $walletService;

    public function __construct(CustomerWalletServiceInterface $walletService)
    {
        $this->walletService = $walletService;
    }

    public function index(Request $request)
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Wallet data fetched successfully',
                'data' => $this->walletService->index($request->user(), $request)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function addBalance(Request $request)
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Balance added successfully',
                'data' => $this->walletService->addBalance($request->user(), $request)
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
}