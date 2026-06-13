{{-- resources/views/provider/dashboard.blade.php --}}
@extends('layouts.admin.app')
@section('title','Provider Dashboard')
@section('page_title','Dashboard')

@section('content')

{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    @foreach([
        ['Total Booking','fas fa-calendar-check',$stats['total_bookings'],'bg-blue-100 text-blue-600'],
        ['Total Service','fas fa-tools',$stats['total_services'],'bg-purple-100 text-purple-600'],
        ['Remaining Payout','fas fa-wallet','$'.number_format($stats['remaining_payout'],2),'bg-green-100 text-green-600'],
        ['Total Revenue','fas fa-chart-line','$'.number_format($stats['total_revenue'],2),'bg-orange-100 text-orange-600'],
    ] as $card)
    <div class="stat-card">
        <div class="w-12 h-12 {{ $card[3] }} rounded-xl flex items-center justify-center flex-shrink-0 text-lg">
            <i class="{{ $card[1] }}"></i>
        </div>
        <div>
            <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $card[2] }}</p>
            <p class="text-xs text-gray-500">{{ $card[0] }}</p>
        </div>
    </div>
    @endforeach
</div>

{{-- Revenue Chart --}}
<div class="card p-6 mb-8">
    <div class="flex justify-between items-center mb-4">
        <h2 class="font-bold text-gray-900 dark:text-white">Monthly Revenue</h2>
    </div>
    <canvas id="revenueChart" height="90"></canvas>
</div>

{{-- Top Handymen + Recent Bookings --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="card p-5">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-sm text-gray-900 dark:text-white">Top Handyman</h3>
            <a href="{{ route('provider.handymen.index') }}" class="text-primary-600 text-xs hover:underline">View All</a>
        </div>
        <div class="space-y-3">
            @forelse($topHandymen as $h)
            <div class="flex items-center gap-3">
                <img src="{{ $h->profile_image_url }}" class="w-10 h-10 rounded-full object-cover" alt="">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $h->full_name }}</p>
                    <p class="text-xs text-gray-400">{{ $h->created_at->format('M d, Y g:i A') }}</p>
                </div>
            </div>
            @empty
            <p class="text-sm text-gray-400 text-center py-4">No handymen yet</p>
            @endforelse
        </div>
    </div>

    <div class="card p-5">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-sm text-gray-900 dark:text-white">Recent Bookings</h3>
            <a href="{{ route('provider.bookings.index') }}" class="text-primary-600 text-xs hover:underline">View All</a>
        </div>
        <div class="space-y-3">
            @forelse($recentBookings as $b)
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                    <img src="{{ $b->customer->profile_image_url }}" class="w-10 h-10 rounded-full object-cover" alt="">
                </div>
                <div class="flex-1">
                    <p class="text-xs text-gray-500">#{{ $b->id }}</p>
                    <p class="text-xs text-gray-400">{{ $b->booking_date->format('M d, Y g:i A') }}</p>
                </div>
                @php $sc=['completed'=>'badge-success','pending'=>'badge-warning','cancelled'=>'badge-danger']; @endphp
                <span class="badge {{ $sc[$b->status] ?? 'badge-pending' }}">{{ ucfirst($b->status) }}</span>
            </div>
            @empty
            <p class="text-sm text-gray-400 text-center py-4">No recent bookings</p>
            @endforelse
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
        labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        datasets: [{
            data: @json($revenueData),
            borderColor:'#6366f1',backgroundColor:'rgba(99,102,241,0.06)',
            borderWidth:2,tension:0.4,fill:true,
            pointBackgroundColor:'#6366f1',pointRadius:3,
        }]
    },
    options:{responsive:true,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,ticks:{callback:v=>'$'+v}},x:{grid:{display:false}}}}
});
</script>
@endpush
