@extends('layouts.public.app')
@section('title','Book - '.$service->name)

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">

    {{-- Breadcrumb --}}
    <nav class="text-sm text-gray-500 mb-6 flex items-center gap-2">
        <a href="{{ route('home') }}" class="hover:text-primary-600">Home</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <a href="{{ route('services') }}" class="hover:text-primary-600">Services</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800 dark:text-gray-200">Book</span>
    </nav>

    {{-- Service Summary --}}
    <div class="card p-5 mb-8 flex flex-col sm:flex-row items-start gap-5">
        <img src="{{ $service->image_url }}" alt="{{ $service->name }}" class="w-24 h-24 rounded-xl object-cover flex-shrink-0">
        <div class="flex-1">
            <h1 class="text-xl font-bold text-gray-900 dark:text-white mb-1">{{ $service->name }}</h1>
            <p class="text-sm text-gray-500">Category: <span class="text-gray-700 dark:text-gray-300">{{ $service->category->name }}</span>
            @if($service->subCategory) › {{ $service->subCategory->name }} @endif</p>
            <div class="flex items-center gap-2 mt-1">
                <img src="{{ $service->provider->profile_image_url }}" class="w-5 h-5 rounded-full" alt="">
                <span class="text-sm text-gray-500">{{ $service->provider->full_name }}</span>
                <span class="mx-1">·</span>
                <div class="flex">
                    @for($i=1;$i<=5;$i++)
                    <i class="fas fa-star text-xs {{ $i <= round($service->avg_rating) ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                    @endfor
                </div>
                <span class="text-xs text-gray-400">{{ $service->avg_rating }} ({{ $service->total_reviews }})</span>
            </div>
        </div>
        <div class="text-right">
            <p class="text-2xl font-bold text-primary-600">
                @if($service->price == 0) Free
                @else ${{ number_format($service->discounted_price, 2) }}
                @endif
            </p>
            @if($service->duration)
            <p class="text-xs text-gray-400">/ {{ $service->duration }} min</p>
            @endif
        </div>
    </div>

    <form method="POST" action="{{ route('customer.booking.store', $service) }}" id="bookingForm">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Left: Schedule --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="card p-6">
                    <h2 class="font-bold text-lg text-gray-900 dark:text-white mb-5">Schedule Service</h2>

                    <div class="mb-5">
                        <label class="form-label">Date And Time <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="booking_date" required
                               min="{{ now()->addHour()->format('Y-m-d\TH:i') }}"
                               class="form-input" id="bookingDate">
                        @error('booking_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="mb-5">
                        <label class="form-label">Quantity</label>
                        <div class="flex items-center gap-4 border border-gray-200 dark:border-gray-600 rounded-xl px-4 py-2 w-44">
                            <button type="button" onclick="changeQty(-1)" class="text-gray-500 hover:text-primary-600 w-6 h-6 flex items-center justify-center text-xl font-bold">-</button>
                            <span id="qtyDisplay" class="flex-1 text-center font-semibold">1</span>
                            <button type="button" onclick="changeQty(1)" class="text-gray-500 hover:text-primary-600 w-6 h-6 flex items-center justify-center text-xl font-bold">+</button>
                            <input type="hidden" name="quantity" id="qtyInput" value="1">
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="form-label">Location <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <i class="fas fa-map-marker-alt absolute left-4 top-3.5 text-gray-400"></i>
                            <textarea name="address" rows="2" required placeholder="e.g. 72 Elite Street, Union Square, San Francisco, CA 94102"
                                      class="form-input pl-10" id="addressInput">{{ old('address') }}</textarea>
                        </div>
                        <button type="button" onclick="getLocation()"
                                class="mt-2 bg-primary-50 text-primary-600 border border-primary-200 px-4 py-1.5 rounded-lg text-xs font-medium hover:bg-primary-100 transition-colors">
                            <i class="fas fa-location-arrow mr-1"></i> Get Current Location
                        </button>
                        <input type="hidden" name="latitude"  id="lat">
                        <input type="hidden" name="longitude" id="lng">
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Additional Notes</label>
                        <textarea name="notes" rows="2" placeholder="Any special instructions..."
                                  class="form-input">{{ old('notes') }}</textarea>
                    </div>
                </div>

                {{-- Addons --}}
                @if($service->addons->count())
                <div class="card p-6">
                    <h3 class="font-bold text-gray-900 dark:text-white mb-4">Add-ons (Optional)</h3>
                    <div class="space-y-3">
                        @foreach($service->addons->where('status','active') as $addon)
                        <label class="flex items-center justify-between cursor-pointer p-3 border border-gray-100 dark:border-gray-700 rounded-xl hover:border-primary-300 transition-colors">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" name="addons[]" value="{{ $addon->id }}"
                                       class="rounded text-primary-600 addon-check" data-price="{{ $addon->price }}">
                                <div class="flex items-center gap-2">
                                    @if($addon->image)
                                    <img src="{{ asset('storage/'.$addon->image) }}" class="w-8 h-8 rounded-lg object-cover" alt="">
                                    @endif
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $addon->name }}</span>
                                </div>
                            </div>
                            <span class="font-bold text-primary-600 text-sm">+${{ number_format($addon->price,2) }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Payment Method --}}
                <div class="card p-6">
                    <h3 class="font-bold text-gray-900 dark:text-white mb-4">Payment Method</h3>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach(['cash'=>'fas fa-money-bill-wave','stripe'=>'fab fa-stripe-s','razorpay'=>'fas fa-rupee-sign','wallet'=>'fas fa-wallet'] as $method => $icon)
                        <label class="cursor-pointer">
                            <input type="radio" name="payment_type" value="{{ $method }}" class="hidden peer" {{ $method==='cash'?'checked':'' }}>
                            <div class="flex items-center gap-2 p-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl peer-checked:border-primary-500 peer-checked:bg-primary-50 dark:peer-checked:bg-primary-900/20 transition-all">
                                <i class="{{ $icon }} text-primary-600"></i>
                                <span class="text-sm font-medium capitalize text-gray-700 dark:text-gray-300">{{ ucfirst($method) }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Right: Price Summary --}}
            <div class="lg:col-span-1">
                <div class="card p-6 sticky top-24">
                    <h3 class="font-bold text-gray-900 dark:text-white mb-5">Price Detail</h3>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Price</span>
                            <span class="font-medium" id="basePrice">${{ number_format($service->price,2) }}</span>
                        </div>
                        @if($service->discount > 0)
                        <div class="flex justify-between text-green-600">
                            <span>Discount ({{ $service->discount }}% Off)</span>
                            <span id="discountAmt">-${{ number_format($service->price - $service->discounted_price, 2) }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Coupon</span>
                            <button type="button" onclick="document.getElementById('couponModal').classList.remove('hidden')"
                                    class="text-primary-600 hover:underline font-medium" id="couponBtn">Apply Coupon</button>
                            <input type="hidden" name="coupon_code" id="couponCode">
                        </div>
                        <div class="flex justify-between text-gray-600 dark:text-gray-400">
                            <span>Subtotal</span>
                            <span id="subtotal">${{ number_format($service->discounted_price,2) }}</span>
                        </div>
                        <div class="flex justify-between text-orange-600">
                            <span>Tax <i class="fas fa-info-circle text-xs cursor-help" title="Tax applied"></i></span>
                            <span id="taxAmt">+$0.00</span>
                        </div>
                        <div class="flex justify-between pt-3 border-t border-gray-100 dark:border-gray-700 font-bold text-base text-gray-900 dark:text-white">
                            <span>Total</span>
                            <span id="total">${{ number_format($service->discounted_price,2) }}</span>
                        </div>
                    </div>

                    <div class="flex gap-3 mt-6">
                        <a href="{{ route('service.detail',$service) }}" class="btn-secondary flex-1 justify-center">Cancel</a>
                        @auth
                        <button type="submit" class="btn-primary flex-1 justify-center">
                            <i class="fas fa-calendar-check"></i> Book Now
                        </button>
                        @else
                        <a href="{{ route('login') }}" class="btn-primary flex-1 justify-center">
                            <i class="fas fa-sign-in-alt"></i> Login to Book
                        </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- Coupon Modal --}}
<div id="couponModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-white dark:bg-gray-800 rounded-2xl w-full max-w-sm p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-gray-900 dark:text-white">Apply Coupon</h3>
            <button onclick="document.getElementById('couponModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <p class="text-sm text-gray-500 mb-3">Available Coupon</p>
        <div id="availableCoupons" class="space-y-2 mb-4 max-h-48 overflow-y-auto">
            {{-- Loaded via JS --}}
        </div>

        <div class="flex gap-2">
            <input type="text" id="manualCoupon" placeholder="Enter coupon code" class="form-input flex-1">
            <button onclick="applyCoupon(document.getElementById('manualCoupon').value)" class="btn-primary px-5">
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
const taxRate   = 0.135; // 13.5% - load from backend ideally

function changeQty(d) {
    qty = Math.max(1, qty + d);
    document.getElementById('qtyDisplay').textContent = qty;
    document.getElementById('qtyInput').value = qty;
    recalculate();
}

let couponDiscount = 0;
let addonTotal = 0;

function recalculate() {
    const base = basePrice * qty + addonTotal;
    const orig = origPrice * qty;
    const discAmt = orig - base;
    const afterCoupon = base - couponDiscount;
    const tax = afterCoupon * taxRate;
    const total = afterCoupon + tax;

    document.getElementById('basePrice').textContent = '$' + orig.toFixed(2);
    if(document.getElementById('discountAmt'))
        document.getElementById('discountAmt').textContent = '-$' + discAmt.toFixed(2);
    document.getElementById('subtotal').textContent  = '$' + afterCoupon.toFixed(2);
    document.getElementById('taxAmt').textContent    = '+$' + tax.toFixed(2);
    document.getElementById('total').textContent     = '$' + total.toFixed(2);
}

// Addons
document.querySelectorAll('.addon-check').forEach(cb => {
    cb.addEventListener('change', () => {
        addonTotal = [...document.querySelectorAll('.addon-check:checked')]
            .reduce((s,c) => s + parseFloat(c.dataset.price), 0);
        recalculate();
    });
});

// Coupon
function applyCoupon(code) {
    if(!code) return;
    fetch('{{ route("customer.coupon.apply") }}', {
        method: 'POST',
        headers: {'X-CSRF-TOKEN':'{{ csrf_token() }}','Content-Type':'application/json','Accept':'application/json'},
        body: JSON.stringify({code, service_id: {{ $service->id }}, amount: basePrice * qty})
    })
    .then(r=>r.json()).then(d=>{
        const msg = document.getElementById('couponMsg');
        if(d.success) {
            couponDiscount = d.discount;
            document.getElementById('couponCode').value = code;
            document.getElementById('couponBtn').textContent = code + ' ✓';
            document.getElementById('couponBtn').classList.add('text-green-600');
            document.getElementById('couponModal').classList.add('hidden');
            msg.innerHTML = '';
            recalculate();
        } else {
            msg.innerHTML = '<span class="text-red-500">' + d.message + '</span>';
        }
    });
}

// Geolocation
function getLocation() {
    if(navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(pos => {
            document.getElementById('lat').value = pos.coords.latitude;
            document.getElementById('lng').value = pos.coords.longitude;
            document.getElementById('addressInput').placeholder = 'Location captured: ' + pos.coords.latitude.toFixed(4) + ', ' + pos.coords.longitude.toFixed(4);
        });
    }
}

recalculate();
</script>
@endpush
