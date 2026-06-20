@extends('layouts.public.app')
@section('title','Book - '.$service->name)

@section('content')

<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <nav class="text-sm text-gray-500 mb-6 flex flex-wrap items-center gap-2">
            <a href="{{ route('home') }}" class="hover:text-primary-600">Home</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <a href="{{ route('services') }}" class="hover:text-primary-600">Services</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-gray-800">Book</span>
        </nav>

        <div class="bg-white rounded-3xl shadow-sm p-5 sm:p-6 mb-8">
            <div class="flex flex-col md:flex-row gap-6 md:items-center md:justify-between">
                <div class="flex flex-col sm:flex-row gap-5">
                    <img src="{{ $service->image_url }}"
                         class="w-full sm:w-32 h-44 sm:h-32 rounded-2xl object-cover"
                         alt="{{ $service->name }}">

                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
                            {{ $service->name }}
                        </h1>

                        <p class="text-sm text-gray-500 mt-2">
                            Category:
                            <span class="font-medium text-gray-700">
                                {{ $service->category->name ?? '-' }}
                            </span>
                            @if($service->subCategory)
                                › {{ $service->subCategory->name }}
                            @endif
                        </p>

                        <div class="flex flex-wrap items-center gap-2 mt-3">
                            <img src="{{ $service->provider->profile_image_url }}"
                                 class="w-7 h-7 rounded-full object-cover">
                            <span class="text-sm text-gray-600">{{ $service->provider->full_name }}</span>
                            <span class="text-gray-300">•</span>

                            <div class="flex">
                                @for($i=1;$i<=5;$i++)
                                    <i class="fas fa-star text-sm {{ $i <= round($service->avg_rating) ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                @endfor
                            </div>

                            <span class="text-sm text-gray-400">
                                {{ $service->avg_rating }} ({{ $service->total_reviews }})
                            </span>
                        </div>
                    </div>
                </div>

                <div class="text-left md:text-right">
                    <p class="text-3xl font-bold text-primary-600">
                        @if($service->price == 0)
                            Free
                        @else
                            ${{ number_format($service->discounted_price, 2) }}
                        @endif
                    </p>

                    @if($service->duration)
                        <p class="text-sm text-gray-400 mt-1">/ {{ $service->duration }} min</p>
                    @endif
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('customer.booking.store', $service) }}" id="bookingForm">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 space-y-6">

                    <div class="bg-white rounded-3xl shadow-sm p-5 sm:p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">
                            <i class="fas fa-calendar-check text-primary-600 mr-2"></i>
                            Schedule Service
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                            <div>
                                <label class="form-label">Date And Time <span class="text-red-500">*</span></label>
                                <input type="datetime-local"
                                       name="booking_date"
                                       required
                                       min="{{ now()->addHour()->format('Y-m-d\TH:i') }}"
                                       class="form-input"
                                       id="bookingDate">
                                @error('booking_date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label">Quantity</label>

                                <div class="flex items-center justify-between border border-gray-200 rounded-xl px-4 py-3 w-full">
                                    <button type="button"
                                            onclick="changeQty(-1)"
                                            class="w-9 h-9 rounded-lg bg-gray-100 hover:bg-primary-600 hover:text-white text-xl font-bold">
                                        -
                                    </button>

                                    <span id="qtyDisplay" class="font-bold text-lg">1</span>

                                    <button type="button"
                                            onclick="changeQty(1)"
                                            class="w-9 h-9 rounded-lg bg-gray-100 hover:bg-primary-600 hover:text-white text-xl font-bold">
                                        +
                                    </button>

                                    <input type="hidden" name="quantity" id="qtyInput" value="1">
                                </div>
                            </div>

                            <div class="md:col-span-2">
                                <label class="form-label">Location <span class="text-red-500">*</span></label>

                                <div class="relative">
                                    <i class="fas fa-map-marker-alt absolute left-4 top-4 text-gray-400"></i>

                                    <textarea name="address"
                                              rows="3"
                                              required
                                              placeholder="e.g. 72 Elite Street, Union Square, San Francisco, CA 94102"
                                              class="form-input pl-10"
                                              id="addressInput">{{ old('address') }}</textarea>
                                </div>

                                <button type="button"
                                        onclick="getLocation()"
                                        class="mt-3 inline-flex items-center gap-2 bg-primary-50 text-primary-600 border border-primary-200 px-4 py-2 rounded-xl text-sm font-medium hover:bg-primary-100">
                                    <i class="fas fa-location-arrow"></i>
                                    Get Current Location
                                </button>

                                <input type="hidden" name="latitude" id="lat">
                                <input type="hidden" name="longitude" id="lng">
                            </div>

                            <div class="md:col-span-2">
                                <label class="form-label">Additional Notes</label>
                                <textarea name="notes"
                                          rows="3"
                                          placeholder="Any special instructions..."
                                          class="form-input">{{ old('notes') }}</textarea>
                            </div>

                        </div>
                    </div>

                    @if($service->addons->count())
                        <div class="bg-white rounded-3xl shadow-sm p-5 sm:p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-5">
                                <i class="fas fa-plus-circle text-primary-600 mr-2"></i>
                                Add-ons Optional
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($service->addons->where('status','active') as $addon)
                                    <label class="cursor-pointer">
                                        <input type="checkbox"
                                               name="addons[]"
                                               value="{{ $addon->id }}"
                                               class="hidden peer addon-check"
                                               data-price="{{ $addon->price }}">

                                        <div class="border-2 border-gray-200 rounded-2xl p-4 flex items-center justify-between peer-checked:border-primary-500 peer-checked:bg-primary-50 transition">
                                            <div class="flex items-center gap-3">
                                                @if($addon->image)
                                                    <img src="{{ asset('storage/'.$addon->image) }}"
                                                         class="w-12 h-12 rounded-xl object-cover">
                                                @endif

                                                <span class="font-semibold text-gray-700">
                                                    {{ $addon->name }}
                                                </span>
                                            </div>

                                            <span class="font-bold text-primary-600">
                                                +${{ number_format($addon->price,2) }}
                                            </span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="bg-white rounded-3xl shadow-sm p-5 sm:p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-5">
                            <i class="fas fa-credit-card text-primary-600 mr-2"></i>
                            Payment Method
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach(['cash'=>'fas fa-money-bill-wave','stripe'=>'fab fa-stripe-s','razorpay'=>'fas fa-rupee-sign','wallet'=>'fas fa-wallet'] as $method => $icon)
                                <label class="cursor-pointer">
                                    <input type="radio"
                                           name="payment_type"
                                           value="{{ $method }}"
                                           class="hidden peer"
                                           {{ $method === 'cash' ? 'checked' : '' }}>

                                    <div class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-2xl peer-checked:border-primary-500 peer-checked:bg-primary-50 transition">
                                        <i class="{{ $icon }} text-primary-600 text-lg"></i>
                                        <span class="font-semibold capitalize text-gray-700">{{ ucfirst($method) }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white rounded-3xl shadow-lg p-5 sm:p-6 sticky top-24">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">
                            Price Detail
                        </h3>

                        <div class="space-y-4 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Price</span>
                                <span class="font-semibold" id="basePrice">${{ number_format($service->price,2) }}</span>
                            </div>

                            @if($service->discount > 0)
                                <div class="flex justify-between text-green-600">
                                    <span>Discount {{ $service->discount }}% Off</span>
                                    <span id="discountAmt">
                                        -${{ number_format($service->price - $service->discounted_price, 2) }}
                                    </span>
                                </div>
                            @endif

                            <div class="flex justify-between">
                                <span class="text-gray-500">Coupon</span>
                                <button type="button"
                                        onclick="document.getElementById('couponModal').classList.remove('hidden')"
                                        class="text-primary-600 hover:underline font-semibold"
                                        id="couponBtn">
                                    Apply Coupon
                                </button>
                                <input type="hidden" name="coupon_code" id="couponCode">
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">Subtotal</span>
                                <span id="subtotal">${{ number_format($service->discounted_price,2) }}</span>
                            </div>

                            <div class="flex justify-between text-orange-600">
                                <span>Tax</span>
                                <span id="taxAmt">+$0.00</span>
                            </div>

                            <div class="flex justify-between pt-4 border-t font-bold text-lg">
                                <span>Total</span>
                                <span id="total">${{ number_format($service->discounted_price,2) }}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2 gap-3 mt-7">
                            <a href="{{ route('service.detail',$service) }}"
                               class="btn-secondary justify-center">
                                Cancel
                            </a>

                            @auth
                                <button type="submit"
                                        class="btn-primary justify-center">
                                    <i class="fas fa-calendar-check"></i>
                                    Book Now
                                </button>
                            @else
                                <a href="{{ route('login') }}"
                                   class="btn-primary justify-center">
                                    <i class="fas fa-sign-in-alt"></i>
                                    Login to Book
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<div id="couponModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 px-4">
    <div class="bg-white rounded-3xl w-full max-w-md p-6 shadow-2xl">
        <div class="flex justify-between items-center mb-5">
            <h3 class="font-bold text-xl text-gray-900">Apply Coupon</h3>

            <button onclick="document.getElementById('couponModal').classList.add('hidden')"
                    class="w-9 h-9 rounded-full bg-gray-100 hover:bg-gray-200">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div id="availableCoupons" class="space-y-2 mb-4 max-h-48 overflow-y-auto"></div>

        <div class="flex gap-2">
            <input type="text" id="manualCoupon" placeholder="Enter coupon code" class="form-input flex-1">

            <button type="button"
                    onclick="applyCoupon(document.getElementById('manualCoupon').value)"
                    class="btn-primary px-5">
                Apply
            </button>
        </div>

        <div id="couponMsg" class="text-xs mt-2"></div>
    </div>
</div>

@endsection

@push('scripts')
<script>
let qty = 1;
const basePrice = {{ $service->discounted_price }};
const origPrice = {{ $service->price }};
const taxRate = 0.135;

let couponDiscount = 0;
let addonTotal = 0;

function changeQty(d) {
    qty = Math.max(1, qty + d);
    document.getElementById('qtyDisplay').textContent = qty;
    document.getElementById('qtyInput').value = qty;
    recalculate();
}

function recalculate() {
    const base = basePrice * qty + addonTotal;
    const orig = origPrice * qty;
    const discAmt = orig - base;
    const afterCoupon = Math.max(0, base - couponDiscount);
    const tax = afterCoupon * taxRate;
    const total = afterCoupon + tax;

    document.getElementById('basePrice').textContent = '$' + orig.toFixed(2);

    if (document.getElementById('discountAmt')) {
        document.getElementById('discountAmt').textContent = '-$' + discAmt.toFixed(2);
    }

    document.getElementById('subtotal').textContent = '$' + afterCoupon.toFixed(2);
    document.getElementById('taxAmt').textContent = '+$' + tax.toFixed(2);
    document.getElementById('total').textContent = '$' + total.toFixed(2);
}

document.querySelectorAll('.addon-check').forEach(cb => {
    cb.addEventListener('change', () => {
        addonTotal = [...document.querySelectorAll('.addon-check:checked')]
            .reduce((sum, item) => sum + parseFloat(item.dataset.price), 0);

        recalculate();
    });
});

function applyCoupon(code) {
    if (!code) return;

    fetch('{{ route("customer.coupon.apply") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            code: code,
            service_id: {{ $service->id }},
            amount: basePrice * qty
        })
    })
    .then(response => response.json())
    .then(data => {
        const msg = document.getElementById('couponMsg');

        if (data.success) {
            couponDiscount = data.discount;
            document.getElementById('couponCode').value = code;
            document.getElementById('couponBtn').textContent = code + ' ✓';
            document.getElementById('couponBtn').classList.add('text-green-600');
            document.getElementById('couponModal').classList.add('hidden');
            msg.innerHTML = '';
            recalculate();
        } else {
            msg.innerHTML = '<span class="text-red-500">' + data.message + '</span>';
        }
    });
}

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(pos => {
            document.getElementById('lat').value = pos.coords.latitude;
            document.getElementById('lng').value = pos.coords.longitude;
            document.getElementById('addressInput').placeholder =
                'Location captured: ' +
                pos.coords.latitude.toFixed(4) +
                ', ' +
                pos.coords.longitude.toFixed(4);
        });
    }
}

recalculate();
</script>
@endpush