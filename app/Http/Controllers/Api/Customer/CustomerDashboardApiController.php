<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Services\Customer\CustomerDashboardService;
use Illuminate\Http\Request;
use Exception;

class CustomerDashboardApiController extends Controller
{
    protected CustomerDashboardService $dashboardService;

    public function __construct(CustomerDashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index(Request $request)
    {
        try {

            $data = $this->dashboardService->dashboard($request->user());

            return response()->json([
                'success' => true,
                'message' => 'Customer dashboard fetched successfully',
                'data' => $data
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => basename($e->getFile())
            ], 500);
        }
    }
}