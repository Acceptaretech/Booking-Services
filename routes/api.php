<?php
use Illuminate\Support\Facades\Route;

// Public
use App\Http\Controllers\Api\Public\HomeApiController;
use App\Http\Controllers\Api\Public\PageApiController;

// Customer
use App\Http\Controllers\Api\Customer\CustomerDashboardApiController;
use App\Http\Controllers\Api\Customer\CustomerAuthApiController;
use App\Http\Controllers\Api\Customer\CustomerProfileApiController;
use App\Http\Controllers\Api\Customer\CustomerBookingApiController;
use App\Http\Controllers\Api\Customer\CustomerAddressApiController;
use App\Http\Controllers\Api\Customer\CustomerWalletApiController;



// Providers
use App\Http\Controllers\Api\Provider\ProviderAuthApiController;




Route::prefix('v1')->group(function () {

    // Public
    Route::prefix('public')->group(function () {

        Route::get('/home', [HomeApiController::class, 'home']);

        Route::get('/categories', [HomeApiController::class, 'categories']);

        Route::get('/services', [HomeApiController::class, 'services']);
        Route::get('/services/{id}', [HomeApiController::class, 'serviceDetail']);

        Route::get('/providers', [HomeApiController::class, 'providers']);
        Route::get('/providers/{id}', [HomeApiController::class, 'providerDetail']);

        Route::get('/blogs', [HomeApiController::class, 'blogs']);
        Route::get('/blogs/{id}', [HomeApiController::class, 'blogDetail']);

        Route::get('/pages/{slug}', [PageApiController::class, 'show']);
    });

    // Customer
    Route::prefix('customer')->group(function () {

        Route::post('/register', [CustomerAuthApiController::class, 'register']);
        Route::post('/login', [CustomerAuthApiController::class, 'login']);

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/logout', [CustomerAuthApiController::class, 'logout']);
            Route::get('/dashboard', [CustomerDashboardApiController::class, 'index']);
            Route::get('/profile', [CustomerProfileApiController::class, 'profile']);
            Route::post('/profile/update', [CustomerProfileApiController::class, 'update']);
            Route::get('/bookings', [CustomerBookingApiController::class, 'index']);
            Route::post('/services/{serviceId}/bookings', [CustomerBookingApiController::class, 'store']);
            Route::get('/bookings/{bookingId}', [CustomerBookingApiController::class, 'show']);
            Route::get('/addresses', [CustomerAddressApiController::class, 'index']);
            Route::post('/addresses', [CustomerAddressApiController::class, 'store']);
            Route::put('/addresses/{addressId}', [CustomerAddressApiController::class, 'update']);
            Route::delete('/addresses/{addressId}', [CustomerAddressApiController::class, 'destroy']);
            Route::post('/addresses/{addressId}/default', [CustomerAddressApiController::class, 'makeDefault']);
            Route::get('/wallet', [CustomerWalletApiController::class, 'index']);
            Route::post('/wallet/add-balance', [CustomerWalletApiController::class, 'addBalance']);
        });
    });

    Route::prefix('provider')->group(function () {
        Route::post('/register', [ProviderAuthApiController::class, 'register']);
        Route::post('/login', [ProviderAuthApiController::class, 'login']);

        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/profile', [ProviderAuthApiController::class, 'profile']);
            Route::post('/logout', [ProviderAuthApiController::class, 'logout']);
        });
    });

});