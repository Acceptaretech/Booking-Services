@extends('layouts.public.app')
@section('title','Booking #'.$booking->booking_number)
@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Booking #{{ $booking->booking_number }}</h1>
            <p class="text-sm text-gray-400">{{ $booking->created_at->format('M d, Y · g:i A') }}</p>
        </div>
        @php $sc=['completed'=>'bg-green-100 text-green-700','pending'=>'bg-yellow-100 text-yellow-700','cancelled'=>'bg-red-100 text-red-700','accepted'=>'bg-blue-100 text-blue-700']; @endphp
        <span class="px-4 py-1.5 rounded-full text-sm font-semibold {{ $sc[$booking->status] ?? 'bg-gray-100 text-gray-600' }}">{{ ucwords(str_replace('_',' ',$booking->status)) }}</span>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-5">
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5">
                <h2 class="font-bold mb-4 text-gray-900 dark:text-white">Service Details</h2>
                <div class="flex gap-4">
                    <img src="{{ $booking->service->image_url }}" class="w-16 h-16 rounded-xl object-cover" alt="">
                    <div><p class="font-semibold text-gray-800 dark:text-gray-200">{{ $booking->service->name }}</p>
                    <p class="text-sm text-gray-500">{{ $booking->service->category->name }}</p>
                    <p class="text-sm text-gray-400">Provider: {{ $booking->provider->full_name }}</p>
                    @if($booking->handyman)<p class="text-sm text-gray-400">Handyman: {{ $booking->handyman->full_name }}</p>@endif</div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5">
                <h2 class="font-bold mb-4 text-gray-900 dark:text-white">Booking Info</h2>
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div><p class="text-gray-400">Date & Time</p><p class="font-medium text-gray-800 dark:text-gray-200">{{ $booking->booking_date->format('M d, Y · g:i A') }}</p></div>
                    <div><p class="text-gray-400">Quantity</p><p class="font-medium text-gray-800 dark:text-gray-200">{{ $booking->quantity }}</p></div>
                    <div class="col-span-2"><p class="text-gray-400">Address</p><p class="font-medium text-gray-800 dark:text-gray-200">{{ $booking->address }}</p></div>
                    @if($booking->notes)<div class="col-span-2"><p class="text-gray-400">Notes</p><p class="font-medium text-gray-800 dark:text-gray-200">{{ $booking->notes }}</p></div>@endif
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5">
                <h2 class="font-bold mb-4 text-gray-900 dark:text-white">Status History</h2>
                <div class="space-y-3">
                    @foreach($booking->statusLogs as $log)
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 rounded-full bg-primary-500 mt-2 flex-shrink-0"></div>
                        <div><p class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ ucwords(str_replace('_',' ',$log->new_status)) }}</p>
                        <p class="text-xs text-gray-400">{{ $log->created_at->format('M d, Y g:i A') }} · by {{ $log->changedBy->full_name ?? 'System' }}</p>
                        @if($log->notes)<p class="text-xs text-gray-400">{{ $log->notes }}</p>@endif</div>
                    </div>
                    @endforeach
                </div>
            </div>
            @if($booking->status === 'completed' && !$booking->review)
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5">
                <h2 class="font-bold mb-4 text-gray-900 dark:text-white">Leave a Review</h2>
                <form method="POST" action="{{ route('customer.booking.review',$booking) }}">
                    @csrf
                    <div class="mb-3"><label class="block text-sm text-gray-600 dark:text-gray-400 mb-1">Rating</label>
                    <select name="rating" class="w-full border border-gray-200 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 outline-none">
                        <option value="5">⭐⭐⭐⭐⭐ Excellent</option><option value="4">⭐⭐⭐⭐ Good</option><option value="3">⭐⭐⭐ Average</option><option value="2">⭐⭐ Poor</option><option value="1">⭐ Very Poor</option>
                    </select></div>
                    <div class="mb-4"><label class="block text-sm text-gray-600 dark:text-gray-400 mb-1">Review</label>
                    <textarea name="review" rows="3" placeholder="Share your experience..." class="w-full border border-gray-200 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 outline-none resize-none"></textarea></div>
                    <button type="submit" class="bg-primary-600 text-white px-6 py-2.5 rounded-xl text-sm font-medium hover:bg-primary-700 transition-colors">Submit Review</button>
                </form>
            </div>
            @endif
        </div>
        <div class="space-y-5">
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5">
                <h2 class="font-bold mb-4 text-gray-900 dark:text-white">Price Breakdown</h2>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-gray-500">Base Price</span><span>${{ number_format($booking->base_price,2) }}</span></div>
                    @if($booking->discount_amount > 0)<div class="flex justify-between text-green-600"><span>Discount</span><span>-${{ number_format($booking->discount_amount,2) }}</span></div>@endif
                    @if($booking->coupon_discount > 0)<div class="flex justify-between text-green-600"><span>Coupon</span><span>-${{ number_format($booking->coupon_discount,2) }}</span></div>@endif
                    @if($booking->tax_amount > 0)<div class="flex justify-between text-orange-500"><span>Tax</span><span>+${{ number_format($booking->tax_amount,2) }}</span></div>@endif
                    <div class="flex justify-between font-bold text-base pt-2 border-t border-gray-100 dark:border-gray-700 text-gray-900 dark:text-white"><span>Total</span><span>${{ number_format($booking->total_amount,2) }}</span></div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700 text-sm">
                    <p class="text-gray-400">Payment: <span class="font-medium text-gray-700 dark:text-gray-300 capitalize">{{ $booking->payment_type }}</span></p>
                    @php $ps=['paid'=>'text-green-600','pending'=>'text-yellow-600','failed'=>'text-red-600']; @endphp
                    <p class="text-gray-400">Status: <span class="font-medium {{ $ps[$booking->payment_status] ?? 'text-gray-600' }}">{{ ucfirst($booking->payment_status) }}</span></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
