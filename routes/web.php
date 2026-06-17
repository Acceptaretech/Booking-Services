<?php

use App\Http\Controllers\Admin\AddonController as AdminAddon;
use App\Http\Controllers\Admin\BannerController as AdminBanner;
// Public

use App\Http\Controllers\Admin\BlogController as AdminBlog;
use App\Http\Controllers\Admin\BookingController as AdminBooking;
// Customer
use App\Http\Controllers\Admin\CategoryController as AdminCategory;
use App\Http\Controllers\Admin\CouponController as AdminCoupon;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\HandymanCommissionController;
// Provider
use App\Http\Controllers\Admin\HandymanController;
use App\Http\Controllers\Admin\HandymanRequestController;
use App\Http\Controllers\Admin\HelpDeskController as AdminHelpDesk;
use App\Http\Controllers\Admin\JobController as AdminJob;
use App\Http\Controllers\Admin\PackageController as AdminPackage;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PaymentController as AdminPayment;
use App\Http\Controllers\Admin\ProviderCommissionController;
use App\Http\Controllers\Admin\ProviderEarningController;
use App\Http\Controllers\Admin\RatingController as AdminRating;
use App\Http\Controllers\Admin\ReportController as AdminReport;
use App\Http\Controllers\Admin\ServiceController as AdminService;
use App\Http\Controllers\Admin\SettingsController as AdminSettings;
use App\Http\Controllers\Admin\ShopController as AdminShop;
use App\Http\Controllers\Admin\SubCategoryController as AdminSubCategory;
// Admin
use App\Http\Controllers\Admin\TaxController as AdminTax;
use App\Http\Controllers\Admin\UserController as AdminUser;
use App\Http\Controllers\Admin\WithdrawalController;
use App\Http\Controllers\Admin\ZoneController as AdminZone;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Customer\AddressController;
use App\Http\Controllers\Customer\BookingController as CustomerBooking;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboard;
use App\Http\Controllers\Customer\ProfileController as CustomerProfile;
use App\Http\Controllers\Customer\WalletController;
use App\Http\Controllers\Provider\AddonController as ProviderAddon;
use App\Http\Controllers\Provider\BookingController as ProviderBooking;
use App\Http\Controllers\Provider\DashboardController as ProviderDashboard;
use App\Http\Controllers\Provider\HandymanCommissionController as ProviderCommission;
use App\Http\Controllers\Provider\HandymanController as ProviderHandyman;
use App\Http\Controllers\Provider\HelpDeskController as ProviderHelpDesk;
use App\Http\Controllers\Provider\JobRequestController as ProviderJobRequest;
use App\Http\Controllers\Provider\PackageController as ProviderPackage;
use App\Http\Controllers\Provider\PaymentController as ProviderPayment;
use App\Http\Controllers\Provider\ProfileController as ProviderProfile;
use App\Http\Controllers\Provider\PromotionalBannerController as ProviderBanner;
use App\Http\Controllers\Provider\RatingController as ProviderRating;
use App\Http\Controllers\Provider\ServiceController as ProviderService;
use App\Http\Controllers\Provider\ShopController as ProviderShop;
use App\Http\Controllers\Provider\WithdrawalController as ProviderWithdrawal;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\PageController as PublicPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\Admin\WalletController;

// PUBLIC
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/categories', [HomeController::class, 'categories'])->name('categories');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/services/{service}', [HomeController::class, 'serviceDetail'])->name('service.detail');
Route::get('/providers', [HomeController::class, 'providers'])->name('providers');
Route::get('/providers/{user}', [HomeController::class, 'providerDetail'])->name('provider.detail');
Route::get('/blogs', [HomeController::class, 'blogs'])->name('blogs');
Route::get('/blogs/{blog}', [HomeController::class, 'blogDetail'])->name('blog.detail');
// User read pages
Route::get('about-us', [PublicPage::class, 'show'])
    ->defaults('slug', 'about-us')
    ->name('pages.about');

Route::get('terms-and-conditions', [PublicPage::class, 'show'])
    ->defaults('slug', 'terms-and-conditions')
    ->name('pages.terms');

Route::get('privacy-policy', [PublicPage::class, 'show'])
    ->defaults('slug', 'privacy-policy')
    ->name('pages.privacy');

Route::get('help-and-support', [PublicPage::class, 'show'])
    ->defaults('slug', 'help-and-support')
    ->name('pages.help');

Route::get('refund-and-cancellation-policy', [PublicPage::class, 'show'])
    ->defaults('slug', 'refund-and-cancellation-policy')
    ->name('pages.refund');

Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
// Route::view('/terms', 'public.terms')->name('terms');
// Route::view('/privacy', 'public.privacy')->name('privacy');
// Route::view('/help', 'public.help')->name('help');
// Route::view('/refund', 'public.refund')->name('refund');

// AUTH
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/register/provider', [AuthController::class, 'showProviderRegister'])->name('provider.register');
    Route::post('/register/provider', [AuthController::class, 'providerRegister']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::post('/settings/theme', function (Request $r) {
    session(['theme' => $r->theme]);

    return response()->json(['ok' => true]);
})->middleware('auth');

// CUSTOMER
Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerDashboard::class, 'index'])->name('dashboard');
    Route::get('/bookings', [CustomerBooking::class, 'index'])->name('bookings.index');
    Route::get('/book/{service}', [CustomerBooking::class, 'create'])->name('booking.create');
    Route::post('/book/{service}', [CustomerBooking::class, 'store'])->name('booking.store');
    Route::get('/bookings/{booking}', [CustomerBooking::class, 'show'])->name('booking.show');
    Route::post('/calculate-price', [CustomerBooking::class, 'calculatePrice'])->name('booking.price');
    Route::post('/apply-coupon', [CustomerBooking::class, 'applyCoupon'])->name('coupon.apply');
    Route::post('/booking/{booking}/review', [CustomerBooking::class, 'addReview'])->name('booking.review');
    Route::get('/profile', [CustomerProfile::class, 'index'])->name('profile');
    Route::post('/profile/update', [CustomerProfile::class, 'update'])->name('profile.update');
    Route::get('/addresses', [AddressController::class, 'index'])->name('addresses');
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::put('/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');
    Route::post('/addresses/{address}/default', [AddressController::class, 'makeDefault'])->name('addresses.default');
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet');
    Route::post('/wallet/add-balance', [WalletController::class, 'addBalance'])->name('wallet.add-balance');
});

// PROVIDER
Route::middleware(['auth', 'role:provider'])->prefix('provider')->name('provider.')->group(function () {
    Route::get('/dashboard', [ProviderDashboard::class, 'index'])->name('dashboard');

    Route::get('/bookings', [ProviderBooking::class, 'index'])->name('bookings.index');
    Route::delete('/bookings/{booking}', [ProviderBooking::class, 'destroy'])->name('bookings.destroy');
    Route::get('/bookings/export', [ProviderBooking::class, 'export'])->name('bookings.export');
    Route::patch('/bookings/{booking}/status', [ProviderBooking::class, 'updateStatus'])->name('bookings.status');
    Route::patch('/bookings/{booking}/handyman', [ProviderBooking::class, 'assignHandyman'])->name('bookings.assign');
    Route::delete('/bookings/{booking}', [ProviderBooking::class, 'destroy'])->name('bookings.destroy');

    // Services
    Route::get('/services', [ProviderService::class, 'index'])->name('services.index');
    Route::get('/services/create', [ProviderService::class, 'create'])->name('services.create');
    Route::post('/services', [ProviderService::class, 'store'])->name('services.store');
    Route::get('/services/{service}/edit', [ProviderService::class, 'edit'])->name('services.edit');
    Route::put('/services/{service}', [ProviderService::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [ProviderService::class, 'destroy'])->name('services.destroy');
    Route::patch('/services/{service}/toggle', [ProviderService::class, 'toggleStatus'])->name('services.toggle');

    Route::get('/services/{service}/faqs', [ProviderService::class, 'faqs'])->name('services.faqs');
    Route::post('/services/{service}/faqs', [ProviderService::class, 'storeFaq'])->name('services.faqs.store');

    Route::get('/service-request-list', [ProviderService::class, 'requestList'])->name('services.requests');

    // ADD THESE TWO ROUTES
    Route::post('/services/bulk-action', [ProviderService::class, 'bulkAction'])
        ->name('services.bulk-action');

    Route::get('/services/{service}', [ProviderService::class, 'show'])
        ->name('services.show');
    Route::get('/get-subcategories/{category}', [ProviderService::class, 'getSubCategories'])
        ->name('services.get-subcategories');

    Route::get('/shops', [ProviderShop::class, 'index'])->name('shops.index');
    Route::get('/shops/create', [ProviderShop::class, 'create'])->name('shops.create');
    Route::post('/shops', [ProviderShop::class, 'store'])->name('shops.store');
    Route::get('/shops/{shop}', [ProviderShop::class, 'show'])->name('shops.show');
    Route::get('/shops/{shop}/edit', [ProviderShop::class, 'edit'])->name('shops.edit');
    Route::put('/shops/{shop}', [ProviderShop::class, 'update'])->name('shops.update');
    Route::delete('/shops/{shop}', [ProviderShop::class, 'destroy'])->name('shops.destroy');
    Route::patch('/shops/{shop}/toggle', [ProviderShop::class, 'toggleStatus'])->name('shops.toggle');
    Route::post('/shops/bulk-action', [ProviderShop::class, 'bulkAction'])->name('shops.bulk-action');

    Route::get('/packages', [ProviderPackage::class, 'index'])->name('packages.index');
    Route::get('/packages/create', [ProviderPackage::class, 'create'])->name('packages.create');
    Route::post('/packages', [ProviderPackage::class, 'store'])->name('packages.store');
    Route::get('/packages/{package}/edit', [ProviderPackage::class, 'edit'])->name('packages.edit');
    Route::put('/packages/{package}', [ProviderPackage::class, 'update'])->name('packages.update');
    Route::delete('/packages/{package}', [ProviderPackage::class, 'destroy'])->name('packages.destroy');
    Route::patch('/packages/{package}/toggle', [ProviderPackage::class, 'toggleStatus'])->name('packages.toggle');
    Route::post('/packages/bulk-action', [ProviderPackage::class, 'bulkAction'])->name('packages.bulk-action');

    Route::get('/addons', [ProviderAddon::class, 'index'])->name('addons.index');
    Route::get('/addons/create', [ProviderAddon::class, 'create'])->name('addons.create');
    Route::post('/addons', [ProviderAddon::class, 'store'])->name('addons.store');
    Route::get('/addons/{addon}/edit', [ProviderAddon::class, 'edit'])->name('addons.edit');
    Route::put('/addons/{addon}', [ProviderAddon::class, 'update'])->name('addons.update');
    Route::delete('/addons/{addon}', [ProviderAddon::class, 'destroy'])->name('addons.destroy');
    Route::patch('/addons/{addon}/toggle', [ProviderAddon::class, 'toggleStatus'])->name('addons.toggle');
    Route::post('/addons/bulk-action', [ProviderAddon::class, 'bulkAction'])->name('addons.bulk-action');

    Route::get('/job-requests', [ProviderJobRequest::class, 'index'])->name('job-requests.index');
    Route::get('/job-requests/{jobRequest}', [ProviderJobRequest::class, 'show'])->name('job-requests.show');
    Route::delete('/job-requests/{jobRequest}', [ProviderJobRequest::class, 'destroy'])->name('job-requests.destroy');
    Route::post('/job-requests/bulk-action', [ProviderJobRequest::class, 'bulkAction'])->name('job-requests.bulk-action');

    Route::get('/handymen', [ProviderHandyman::class, 'index'])->name('handymen.index');
    Route::get('/handymen/create', [ProviderHandyman::class, 'create'])->name('handymen.create');
    Route::post('/handymen', [ProviderHandyman::class, 'store'])->name('handymen.store');
    Route::get('/handymen/{user}/edit', [ProviderHandyman::class, 'edit'])->name('handymen.edit');
    Route::put('/handymen/{user}', [ProviderHandyman::class, 'update'])->name('handymen.update');
    Route::delete('/handymen/{user}', [ProviderHandyman::class, 'destroy'])->name('handymen.destroy');
    Route::get('/handymen/requests', [ProviderHandyman::class, 'requests'])->name('handymen.requests');
    Route::get('/handymen/unassigned', [ProviderHandyman::class, 'unassigned'])->name('handymen.unassigned');
    Route::post('/handymen/bulk-action', [ProviderHandyman::class, 'bulkAction'])->name('handymen.bulk-action');
    Route::get('/handyman-commissions', [ProviderCommission::class, 'index'])->name('handyman-commissions.index');
    Route::get('/handyman-commissions/create', [ProviderCommission::class, 'create'])->name('handyman-commissions.create');
    Route::post('/handyman-commissions', [ProviderCommission::class, 'store'])->name('handyman-commissions.store');
    Route::get('/handyman-commissions/{hc}/edit', [ProviderCommission::class, 'edit'])->name('handyman-commissions.edit');
    Route::put('/handyman-commissions/{hc}', [ProviderCommission::class, 'update'])->name('handyman-commissions.update');
    Route::delete('/handyman-commissions/{hc}', [ProviderCommission::class, 'destroy'])->name('handyman-commissions.destroy');

    Route::get('/payments', [ProviderPayment::class, 'index'])->name('payments.index');
    Route::get('/cash-payments', [ProviderPayment::class, 'cash'])->name('payments.cash');
    Route::get('/handyman-earnings', [ProviderPayment::class, 'handymanEarnings'])->name('payments.handyman');
    Route::get('/withdrawal-requests', [ProviderWithdrawal::class, 'index'])->name('withdrawal.index');
    Route::post('/withdrawal-requests', [ProviderWithdrawal::class, 'store'])->name('withdrawal.store');

    Route::get('/banners', [ProviderBanner::class, 'index'])->name('banners.index');
    Route::get('/banners/create', [ProviderBanner::class, 'create'])->name('banners.create');
    Route::post('/banners', [ProviderBanner::class, 'store'])->name('banners.store');
    Route::get('/banners/{banner}', [ProviderBanner::class, 'show'])->name('banners.show');
    Route::delete('/banners/{banner}', [ProviderBanner::class, 'destroy'])->name('banners.destroy');

    Route::get('/ratings', [ProviderRating::class, 'index'])->name('ratings.index');

    Route::get('/help-desk', [ProviderHelpDesk::class, 'index'])->name('help-desk.index');
    Route::get('/help-desk/create', [ProviderHelpDesk::class, 'create'])->name('help-desk.create');
    Route::post('/help-desk', [ProviderHelpDesk::class, 'store'])->name('help-desk.store');
    Route::get('/help-desk/{helpDesk}', [ProviderHelpDesk::class, 'show'])->name('help-desk.show');
    Route::delete('/help-desk/{helpDesk}', [ProviderHelpDesk::class, 'destroy'])->name('help-desk.destroy');

    Route::get('/profile', [ProviderProfile::class, 'index'])->name('profile');
    Route::post('/profile', [ProviderProfile::class, 'update'])->name('profile.update');
    Route::get('/my-info', [ProviderProfile::class, 'info'])->name('profile.info');
    Route::get('/billing', [ProviderProfile::class, 'billing'])->name('profile.billing');
    Route::get('/settings', [ProviderProfile::class, 'settings'])->name('profile.settings');
});

// ADMIN
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    Route::get('/bookings', [AdminBooking::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [AdminBooking::class, 'show'])->name('bookings.show');
    Route::patch('/bookings/{booking}/status', [AdminBooking::class, 'updateStatus'])->name('bookings.status');
    Route::patch('/bookings/{booking}/handyman', [AdminBooking::class, 'assignHandyman'])->name('bookings.assign');
    Route::delete('/bookings/{booking}', [AdminBooking::class, 'destroy'])->name('bookings.destroy');
    Route::post('/bookings/export', [AdminBooking::class, 'export'])->name('bookings.export');

    Route::get('/categories', [AdminCategory::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [AdminCategory::class, 'create'])->name('categories.create');
    Route::post('/categories', [AdminCategory::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}', [AdminCategory::class, 'show'])->name('categories.show');
    Route::get('/categories/{category}/edit', [AdminCategory::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [AdminCategory::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminCategory::class, 'destroy'])->name('categories.destroy');
    Route::patch('/categories/{category}/toggle', [AdminCategory::class, 'toggleStatus'])->name('categories.toggle');

    Route::get('/sub-categories', [AdminSubCategory::class, 'index'])->name('sub-categories.index');
    Route::get('/sub-categories/create', [AdminSubCategory::class, 'create'])->name('sub-categories.create');
    Route::post('/sub-categories', [AdminSubCategory::class, 'store'])->name('sub-categories.store');
    Route::get('/sub-categories/{subCategory}', [AdminSubCategory::class, 'show'])->name('sub-categories.show');
    Route::get('/sub-categories/{subCategory}/edit', [AdminSubCategory::class, 'edit'])->name('sub-categories.edit');
    Route::put('/sub-categories/{subCategory}', [AdminSubCategory::class, 'update'])->name('sub-categories.update');
    Route::delete('/sub-categories/{subCategory}', [AdminSubCategory::class, 'destroy'])->name('sub-categories.destroy');

    Route::get('/services', [AdminService::class, 'index'])->name('services.index');
    Route::get('/services/create', [AdminService::class, 'create'])->name('services.create');
    Route::post('/services', [AdminService::class, 'store'])->name('services.store');
    Route::get('/services/{service}', [AdminService::class, 'show'])->name('services.show');
    Route::get('/services/{service}/edit', [AdminService::class, 'edit'])->name('services.edit');
    Route::put('/services/{service}', [AdminService::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [AdminService::class, 'destroy'])->name('services.destroy');

    // dependent dropdown ajax
    Route::get('/services/get-subcategories/{category}', [AdminService::class, 'getSubcategories'])
        ->name('services.getSubcategories');

    Route::get('/services/get-zones-by-provider/{provider}', [AdminService::class, 'getZonesByProvider'])
        ->name('services.getZonesByProvider');

    // PACKAGES
    Route::get('/packages', function () {
        return view('admin.packages.index');
    })->name('packages.index');

    Route::resource('packages', AdminPackage::class);
    // // SERVICE REQUESTS
    // Route::get('/service-requests', function () {
    //     return view('admin.service-requests.index');
    // })->name('service-requests.index');

    Route::resource('addons', AdminAddon::class);
    Route::resource('shops', AdminShop::class);

    Route::get('/providers', [AdminUser::class, 'providers'])
        ->name('providers.index');

    Route::get('/provider-requests', [AdminUser::class, 'providerRequests'])
        ->name('providers.requests');

    Route::get('/providers/{user}', [AdminUser::class, 'showProvider'])
        ->name('providers.show');

    Route::patch('/providers/{user}/approve', [AdminUser::class, 'approveProvider'])
        ->name('providers.approve');

    Route::patch('/providers/{user}/reject', [AdminUser::class, 'rejectProvider'])
        ->name('providers.reject');

    Route::post('/providers/{user}/commission', [AdminUser::class, 'setCommission'])
        ->name('providers.commission');

    Route::get('/providers/{user}/edit', [AdminUser::class, 'editProvider'])
        ->name('providers.edit');

    Route::put('/providers/{user}', [AdminUser::class, 'updateProvider'])
        ->name('providers.update');

    // Provider-Commissions
    Route::get('/provider-commissions',
        [ProviderCommissionController::class, 'index'])
        ->name('providers.commissions');

    Route::patch('/provider-commissions/{user}/toggle-status',
        [ProviderCommissionController::class, 'toggleStatus'])
        ->name('providers.commissions.toggle');

    Route::delete('/provider-commissions/{user}',
        [ProviderCommissionController::class, 'destroy'])
        ->name('providers.commissions.delete');

    Route::post('/provider-commissions/bulk-action',
        [ProviderCommissionController::class, 'bulkAction'])
        ->name('providers.commissions.bulk');

    Route::get('/customers', [AdminUser::class, 'customers'])->name('customers.index');
    // Route::get('/handymen', [AdminUser::class, 'handymen'])->name('handymen.index');

    // Handymen
    Route::get('/handymen', [HandymanController::class, 'index'])
        ->name('handymen.index');

    Route::get('/handymen/create', [HandymanController::class, 'create'])
        ->name('handymen.create');

    Route::post('/handymen/store', [HandymanController::class, 'store'])
        ->name('handymen.store');

    Route::get('/handymen/{user}/edit', [HandymanController::class, 'edit'])
        ->name('handymen.edit');

    Route::put('/handymen/{user}', [HandymanController::class, 'update'])
        ->name('handymen.update');

    Route::delete('/handymen/{user}', [HandymanController::class, 'destroy'])
        ->name('handymen.destroy');

    Route::post('/handymen/bulk-action', [HandymanController::class, 'bulkAction'])
        ->name('handymen.bulk');

    // HanyMan Request
    Route::get('/handyman-requests', [HandymanRequestController::class, 'index'])
        ->name('handymen.requests');

    Route::patch('/handyman-requests/{user}/accept', [HandymanRequestController::class, 'accept'])
        ->name('handymen.requests.accept');

    Route::patch('/handyman-requests/{user}/reject', [HandymanRequestController::class, 'reject'])
        ->name('handymen.requests.reject');

    Route::post('/handyman-requests/bulk-action', [HandymanRequestController::class, 'bulkAction'])
        ->name('handymen.requests.bulk');

    // Handyman Commission Route
    Route::get('/handyman-commissions', [HandymanCommissionController::class, 'index'])
        ->name('handyman-commissions.index');

    Route::patch('/handyman-commissions/{commission}/toggle', [HandymanCommissionController::class, 'toggle'])
        ->name('handyman-commissions.toggle');

    Route::delete('/handyman-commissions/{commission}', [HandymanCommissionController::class, 'destroy'])
        ->name('handyman-commissions.destroy');

    Route::post('/handyman-commissions/bulk-action', [HandymanCommissionController::class, 'bulkAction'])
        ->name('handyman-commissions.bulk');

    // User
    Route::get('/users', [AdminUser::class, 'allUsers'])
        ->name('users.index');
    Route::get('/users/{user}/edit', [AdminUser::class, 'editUser'])
        ->name('users.edit');
    Route::put('/users/{user}', [AdminUser::class, 'updateUser'])
        ->name('users.update');
    Route::patch('/users/{user}/toggle', [AdminUser::class, 'toggleStatus'])->name('users.toggle');
    Route::delete('/users/{user}', [AdminUser::class, 'destroy'])->name('users.destroy');
    Route::get('/unverified-users', [AdminUser::class, 'unverifiedUsers'])
        ->name('unverified-users.index');
    Route::patch('/unverified-users/{user}/verify', [AdminUser::class, 'verifyUser'])
        ->name('unverified-users.verify');

    Route::get('/payments', [AdminPayment::class, 'index'])
        ->name('payments.index');

    Route::get('/payments/cash', [AdminPayment::class, 'cashPayments'])
        ->name('payments.cash');

    Route::get('/payments/{payment}', [AdminPayment::class, 'show'])
        ->name('payments.show');

    Route::get('/provider-earnings', [ProviderEarningController::class, 'index'])
        ->name('provider-earnings.index');

    Route::get('/provider-earnings/{provider}', [ProviderEarningController::class, 'show'])
        ->name('provider-earnings.show');

    Route::get('/withdrawals', [WithdrawalController::class, 'index'])
        ->name('withdrawals.index');

    Route::get('/withdrawals/{withdrawal}', [WithdrawalController::class, 'show'])
        ->name('withdrawals.show');

    Route::patch('/withdrawals/{withdrawal}/approve', [WithdrawalController::class, 'approve'])
        ->name('withdrawals.approve');

    Route::patch('/withdrawals/{withdrawal}/reject', [WithdrawalController::class, 'reject'])
        ->name('withdrawals.reject');

    // Route::get('/withdrawal-requests', [AdminPayment::class, 'withdrawals'])->name('withdrawals.index');
    // Route::patch('/withdrawal-requests/{wr}/approve', [AdminPayment::class, 'approveWithdrawal'])->name('withdrawals.approve');

    Route::get('/wallet', [WalletController::class, 'index'])
        ->name('wallet.index');

    Route::get('/wallet/{user}', [WalletController::class, 'show'])
        ->name('wallet.show');

    Route::get('/coupons', [AdminCoupon::class, 'index'])->name('coupons.index');
    Route::get('/coupons/create', [AdminCoupon::class, 'create'])->name('coupons.create');
    Route::post('/coupons', [AdminCoupon::class, 'store'])->name('coupons.store');
    Route::get('/coupons/{coupon}', [AdminCoupon::class, 'show'])->name('coupons.show');
    Route::get('/coupons/{coupon}/edit', [AdminCoupon::class, 'edit'])->name('coupons.edit');
    Route::put('/coupons/{coupon}', [AdminCoupon::class, 'update'])->name('coupons.update');
    Route::delete('/coupons/{coupon}', [AdminCoupon::class, 'destroy'])->name('coupons.destroy');

    // Route::get('/blogs', [AdminBlog::class, 'index'])->name('blogs.index');
    // Route::get('/blogs/create', [AdminBlog::class, 'create'])->name('blogs.create');
    // Route::post('/blogs', [AdminBlog::class, 'store'])->name('blogs.store');
    // Route::get('/blogs/{blog}', [AdminBlog::class, 'show'])->name('blogs.show');
    // Route::get('/blogs/{blog}/edit', [AdminBlog::class, 'edit'])->name('blogs.edit');
    // Route::put('/blogs/{blog}', [AdminBlog::class, 'update'])->name('blogs.update');
    // Route::delete('/blogs/{blog}', [AdminBlog::class, 'destroy'])->name('blogs.destroy');
    Route::resource('blogs', AdminBlog::class);

    Route::patch(
        'blogs/{blog}/toggle-status',
        [AdminBlog::class, 'toggleStatus']
    )->name('blogs.toggle');

    Route::post(
        'blogs/bulk-action',
        [AdminBlog::class, 'bulkAction']
    )->name('blogs.bulk');

    Route::get('pages/{slug}', [PageController::class, 'edit'])->name('pages.edit');
    Route::put('pages/{slug}', [PageController::class, 'update'])->name('pages.update');
    // Document
    Route::resource('documents', DocumentController::class);
    Route::patch('documents/{document}/toggle-required', [DocumentController::class, 'toggleRequired'])->name('documents.toggleRequired');
    Route::patch('documents/{document}/toggle-status', [DocumentController::class, 'toggleStatus'])->name('documents.toggleStatus');

    Route::get('/zones', [AdminZone::class, 'index'])->name('zones.index');
    Route::get('/zones/create', [AdminZone::class, 'create'])->name('zones.create');
    Route::post('/zones', [AdminZone::class, 'store'])->name('zones.store');
    Route::get('/zones/{zone}', [AdminZone::class, 'show'])->name('zones.show');
    Route::get('/zones/{zone}/edit', [AdminZone::class, 'edit'])->name('zones.edit');
    Route::put('/zones/{zone}', [AdminZone::class, 'update'])->name('zones.update');
    Route::delete('/zones/{zone}', [AdminZone::class, 'destroy'])->name('zones.destroy');

    Route::get('/taxes', [AdminTax::class, 'index'])->name('taxes.index');
    Route::get('/taxes/create', [AdminTax::class, 'create'])->name('taxes.create');
    Route::post('/taxes', [AdminTax::class, 'store'])->name('taxes.store');
    Route::get('/taxes/{tax}/edit', [AdminTax::class, 'edit'])->name('taxes.edit');
    Route::put('/taxes/{tax}', [AdminTax::class, 'update'])->name('taxes.update');
    Route::delete('/taxes/{tax}', [AdminTax::class, 'destroy'])->name('taxes.destroy');

    Route::get('/job-requests', [AdminJob::class, 'index'])->name('jobs.index');
    Route::get('/job-service-list', [AdminJob::class, 'serviceList'])->name('jobs.services');

    Route::get('/banners', [AdminBanner::class, 'index'])->name('banners.index');
    Route::patch('/banners/{b}/approve', [AdminBanner::class, 'approve'])->name('banners.approve');
    Route::patch('/banners/{b}/reject', [AdminBanner::class, 'reject'])->name('banners.reject');

    Route::get('/reports', [AdminReport::class, 'index'])->name('reports.index');

    // Route::get('/settings', [AdminSettings::class, 'index'])->name('settings.index');
    // Route::post('/settings', [AdminSettings::class, 'update'])->name('settings.update');
    // Route::post('/settings/tax', [AdminSettings::class, 'storeTax'])->name('settings.tax');
    // Route::post('/settings/zone', [AdminSettings::class, 'storeZone'])->name('settings.zone');

    Route::prefix('settings')->name('settings.')->group(function () {

        Route::get('/general', [AdminSettings::class, 'general'])->name('general');
        Route::get('/theme', [AdminSettings::class, 'theme'])->name('theme');
        Route::get('/site', [AdminSettings::class, 'site'])->name('site');
        Route::post('/site/update', [AdminSettings::class, 'update'])->name('site.update');
        Route::get('/service', [AdminSettings::class, 'service'])->name('service');
        Route::post('/service/update', [AdminSettings::class, 'updateService'])->name('service.update');
        Route::get('/app', [AdminSettings::class, 'app'])->name('app');
        Route::get('/notification', [AdminSettings::class, 'notification'])->name('notification');
        Route::get('/social', [AdminSettings::class, 'social'])->name('social');
        Route::post('/social/update', [AdminSettings::class, 'updateSocial'])->name('social.update');
        Route::get('/payment', [AdminSettings::class, 'payment'])->name('payment');
        Route::post('/payment/update', [AdminSettings::class, 'updatePayment'])->name('payment.update');
        Route::get('/mail', [AdminSettings::class, 'mail'])->name('mail');
        Route::post('/mail/update', [AdminSettings::class, 'updateMail'])->name('mail.update');
        Route::get('/roles', [AdminSettings::class, 'roles'])->name('roles');
        Route::get('/earning', [AdminSettings::class, 'earning'])->name('earning');
        Route::get('/language', [AdminSettings::class, 'language'])->name('language');
        Route::get('/banner', [AdminSettings::class, 'banner'])->name('banner');
        Route::get('/seo', [AdminSettings::class, 'seo'])->name('seo');

        Route::post('/update', [AdminSettings::class, 'update'])->name('update');

        Route::post('/tax', [AdminSettings::class, 'storeTax'])->name('tax');
        Route::post('/zone', [AdminSettings::class, 'storeZone'])->name('zone');
    });

    Route::get('/help-desk', [AdminHelpDesk::class, 'index'])->name('help-desk.index');
    Route::get('/help-desk/create', [AdminHelpDesk::class, 'create'])->name('help-desk.create');
    Route::post('/help-desk', [AdminHelpDesk::class, 'store'])->name('help-desk.store');
    Route::get('/help-desk/{helpDesk}', [AdminHelpDesk::class, 'show'])->name('help-desk.show');
    Route::get('/help-desk/{helpDesk}/edit', [AdminHelpDesk::class, 'edit'])->name('help-desk.edit');
    Route::put('/help-desk/{helpDesk}', [AdminHelpDesk::class, 'update'])->name('help-desk.update');
    Route::delete('/help-desk/{helpDesk}', [AdminHelpDesk::class, 'destroy'])->name('help-desk.destroy');

    Route::get('/ratings', [AdminRating::class, 'index'])->name('ratings.index');
});
