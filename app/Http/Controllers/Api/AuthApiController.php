<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{User, Zone};
use Illuminate\Http\{JsonResponse, Request};
use Illuminate\Support\Facades\{Auth, Hash};
use Illuminate\Validation\Rules\Password;

class AuthApiController extends Controller
{
    private function success($data, string $message = 'Success', int $code = 200): JsonResponse
    {
        return response()->json(['success' => true, 'message' => $message, 'data' => $data], $code);
    }

    private function error(string $message, int $code = 422): JsonResponse
    {
        return response()->json(['success' => false, 'message' => $message], $code);
    }

    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'first_name'  => 'required|string|max:100',
            'last_name'   => 'required|string|max:100',
            'email'       => 'required|email|unique:users',
            'phone'       => 'required|string',
            'password'    => ['required', Password::min(8)],
            'role'        => 'nullable|in:customer,provider,handyman',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'password'   => Hash::make($request->password),
            'role'       => $request->role ?? 'customer',
            'status'     => in_array($request->role,['provider','handyman']) ? 'pending' : 'active',
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return $this->success(['user' => $user, 'token' => $token], 'Registered successfully.', 201);
    }

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email','password'))) {
            return $this->error('Invalid credentials.', 401);
        }

        $user = Auth::user();

        if (!$user->isActive()) {
            return $this->error('Your account is not active.', 403);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return $this->success(['user' => $user, 'token' => $token], 'Login successful.');
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return $this->success(null, 'Logged out.');
    }

    public function profile(Request $request): JsonResponse
    {
        return $this->success($request->user()->load('zone','document'));
    }

    public function updateProfile(Request $request): JsonResponse
    {
        $user = $request->user();
        $data = $request->validate([
            'first_name'    => 'sometimes|string|max:100',
            'last_name'     => 'sometimes|string|max:100',
            'phone'         => 'sometimes|string',
            'address'       => 'sometimes|string',
            'profile_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')->store('profiles','public');
        }
        $user->update($data);
        return $this->success($user->fresh(), 'Profile updated.');
    }

    public function sendOtp(Request $request): JsonResponse
    {
        $request->validate(['phone' => 'required|string']);
        $otp  = rand(1000, 9999);
        $user = User::where('phone', $request->phone)->first();
        if (!$user) return $this->error('User not found.', 404);
        $user->update(['otp' => $otp, 'otp_expires_at' => now()->addMinutes(10)]);
        // Send OTP via SMS service here
        return $this->success(['otp' => $otp], 'OTP sent.'); // remove otp from response in production
    }

    public function verifyOtp(Request $request): JsonResponse
    {
        $request->validate(['phone' => 'required', 'otp' => 'required']);
        $user = User::where('phone',$request->phone)->where('otp',$request->otp)->first();
        if (!$user || now()->gt($user->otp_expires_at)) {
            return $this->error('Invalid or expired OTP.', 422);
        }
        $user->update(['is_verified'=>true,'otp'=>null,'otp_expires_at'=>null,'status'=>'active']);
        $token = $user->createToken('api-token')->plainTextToken;
        return $this->success(['user'=>$user,'token'=>$token], 'Verified.');
    }
}

// ── Service API ────────────────────────────────────────────────────────────────

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{Category, Service};
use Illuminate\Http\{JsonResponse, Request};

class ServiceApiController extends Controller
{
    public function categories(): JsonResponse
    {
        $cats = Category::active()->withCount('services')->get();
        return response()->json(['success'=>true,'data'=>$cats]);
    }

    public function services(Request $request): JsonResponse
    {
        $query = Service::with(['provider','category','shop'])->active();

        if ($request->filled('category_id'))    $query->where('category_id',$request->category_id);
        if ($request->filled('provider_id'))    $query->where('user_id',$request->provider_id);
        if ($request->filled('price_min'))      $query->where('price','>=',$request->price_min);
        if ($request->filled('price_max'))      $query->where('price','<=',$request->price_max);
        if ($request->filled('search'))         $query->where('name','like','%'.$request->search.'%');
        if ($request->filled('sort')) {
            match($request->sort) {
                'top_rated'   => $query->topRated(),
                'best_selling'=> $query->bestSelling(),
                'newest'      => $query->latest(),
                default       => $query->latest(),
            };
        }

        $services = $query->paginate(12);
        return response()->json(['success'=>true,'data'=>$services]);
    }

    public function show(Service $service): JsonResponse
    {
        $service->load(['provider','category','subCategory','shop','faqs','addons','reviews.customer']);
        return response()->json(['success'=>true,'data'=>$service]);
    }

    public function topRated(): JsonResponse
    {
        $services = Service::active()->topRated()->with('provider','category')->take(10)->get();
        return response()->json(['success'=>true,'data'=>$services]);
    }

    public function featured(): JsonResponse
    {
        $services = Service::active()->featured()->with('provider','category')->take(10)->get();
        return response()->json(['success'=>true,'data'=>$services]);
    }
}

// ── Booking API ────────────────────────────────────────────────────────────────

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{Booking, Coupon, Service};
use App\Services\BookingService;
use Illuminate\Http\{JsonResponse, Request};

class BookingApiController extends Controller
{
    public function __construct(private BookingService $bookingService) {}

    public function index(Request $request): JsonResponse
    {
        $user     = $request->user();
        $column   = match($user->role) {
            'provider' => 'provider_id',
            'handyman' => 'handyman_id',
            default    => 'customer_id',
        };
        $bookings = Booking::with(['service','provider','handyman','customer'])
            ->where($column, $user->id)
            ->when($request->status, fn($q,$s) => $q->where('status',$s))
            ->latest()->paginate(15);
        return response()->json(['success'=>true,'data'=>$bookings]);
    }

    public function show(Request $request, Booking $booking): JsonResponse
    {
        $user = $request->user();
        if (!in_array($user->id,[$booking->customer_id,$booking->provider_id,$booking->handyman_id])) {
            abort(403);
        }
        $booking->load(['service','provider','handyman','customer','statusLogs','payment','review']);
        return response()->json(['success'=>true,'data'=>$booking]);
    }

    public function calculatePrice(Request $request): JsonResponse
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'quantity'   => 'required|integer|min:1',
            'coupon_code'=> 'nullable|string',
        ]);
        $service   = Service::findOrFail($request->service_id);
        $breakdown = $this->bookingService->calculatePrice(
            $service, $request->quantity, $request->coupon_code
        );
        return response()->json(['success'=>true,'data'=>$breakdown]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'service_id'   => 'required|exists:services,id',
            'booking_date' => 'required|date|after:now',
            'quantity'     => 'required|integer|min:1',
            'address'      => 'required|string',
            'coupon_code'  => 'nullable|string',
            'payment_type' => 'required|in:cash,stripe,razorpay,wallet',
            'addons'       => 'nullable|array',
        ]);

        $service   = Service::with('provider')->findOrFail($request->service_id);
        $breakdown = $this->bookingService->calculatePrice(
            $service, $request->quantity, $request->coupon_code
        );

        $booking = $this->bookingService->createBooking([
            'customer_id'    => $request->user()->id,
            'service_id'     => $request->service_id,
            'provider_id'    => $service->user_id,
            'shop_id'        => $service->shop_id,
            'coupon_id'      => $breakdown['coupon']?->id,
            'addons'         => $request->addons,
            'booking_date'   => $request->booking_date,
            'quantity'       => $request->quantity,
            'address'        => $request->address,
            'latitude'       => $request->latitude,
            'longitude'      => $request->longitude,
            'notes'          => $request->notes,
            'payment_type'   => $request->payment_type,
            ...$breakdown,
        ]);

        return response()->json(['success'=>true,'message'=>'Booking created.','data'=>$booking], 201);
    }

    public function updateStatus(Request $request, Booking $booking): JsonResponse
    {
        $user = $request->user();
        if (!in_array($user->id,[$booking->provider_id,$booking->handyman_id])) {
            abort(403);
        }
        $request->validate(['status'=>'required|string']);
        $updated = $this->bookingService->updateStatus($booking,$request->status,$user->id,$request->notes);
        return response()->json(['success'=>true,'data'=>$updated]);
    }

    public function addReview(Request $request, Booking $booking): JsonResponse
    {
        abort_unless($booking->customer_id === $request->user()->id, 403);
        abort_unless($booking->status === 'completed', 422, 'Can only review completed bookings.');
        $request->validate(['rating'=>'required|numeric|min:1|max:5','review'=>'nullable|string']);

        $review = \App\Models\Review::create([
            'booking_id'  => $booking->id,
            'customer_id' => $request->user()->id,
            'service_id'  => $booking->service_id,
            'provider_id' => $booking->provider_id,
            'handyman_id' => $booking->handyman_id,
            'rating'      => $request->rating,
            'review'      => $request->review,
        ]);

        // Update service avg rating
        $service = $booking->service;
        $avgRating = \App\Models\Review::where('service_id',$service->id)->avg('rating');
        $service->update(['avg_rating'=>round($avgRating,2),'total_reviews'=>\App\Models\Review::where('service_id',$service->id)->count()]);

        return response()->json(['success'=>true,'data'=>$review], 201);
    }
}
