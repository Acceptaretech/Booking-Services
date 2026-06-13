<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Services\Public\HomeService;
use Illuminate\Http\Request;

class HomeApiController extends Controller
{
    protected HomeService $homeService;

    public function __construct()
    {
        $this->homeService = new HomeService();
    }

    public function home()
    {
        return response()->json([
            'success' => true,
            'data' => $this->homeService->home()
        ]);
    }

    public function categories(Request $request)
    {
        return response()->json(
            $this->homeService->categories($request)
        );
    }

    public function services(Request $request)
    {
        return response()->json(
            $this->homeService->services($request)
        );
    }

    public function serviceDetail($id)
    {
        return response()->json(
            $this->homeService->serviceDetail($id)
        );
    }

    public function providers(Request $request)
    {
        return response()->json(
            $this->homeService->providers($request)
        );
    }

    public function providerDetail($id)
    {
        return response()->json(
            $this->homeService->providerDetail($id)
        );
    }

    public function blogs(Request $request)
    {
        return response()->json(
            $this->homeService->blogs($request)
        );
    }

    public function blogDetail($id)
    {
        return response()->json(
            $this->homeService->blogDetail($id)
        );
    }
}