@extends('layouts.admin.app')
@section('title','Bookings')
@section('page_title','Bookings')

@section('content')

{{-- Top bar --}}
<div class="flex flex-wrap items-center justify-between gap-4 mb-6">
    <div class="flex items-center gap-3">
        <span class="text-sm text-gray-600 dark:text-gray-400">
            Total Amount: <strong class="text-gray-900 dark:text-white">${{ number_format($totalAmount,2) }}</strong>
        </span>
        <button onclick="document.getElementById('viewBreakdown').classList.toggle('hidden')"
                class="text-primary-600 text-xs hover:underline">View Breakdown</button>
        <button onclick="document.getElementById('exportModal').classList.remove('hidden')" class="btn-secondary text-xs">
            <i class="fas fa-download"></i> Export
        </button>
    </div>

    <div class="flex items-center gap-3">
        <form method="GET" class="flex items-center gap-2">
            <input name="search" value="{{ request('search') }}" placeholder="Search..." class="form-input w-44 py-2 text-xs">
            <button type="submit" class="btn-primary py-2 text-xs"><i class="fas fa-search"></i></button>
        </form>
        <button onclick="document.getElementById('filterPanel').classList.toggle('hidden')" class="btn-secondary text-xs">
            <i class="fas fa-filter"></i> Filter
        </button>
    </div>
</div>

{{-- Filter Panel --}}
<div id="filterPanel" class="hidden card p-5 mb-6">
    <form method="GET" class="space-y-4">
        <div class="flex items-center justify-between mb-2">
            <h3 class="font-semibold text-sm">Filter</h3>
            <div class="flex gap-2">
                <button type="button" onclick="document.getElementById('filterPanel').querySelector('form').reset()" class="text-gray-400 hover:text-gray-600 text-sm">
                    <i class="fas fa-sync-alt"></i>
                </button>
                <button type="button" onclick="document.getElementById('filterPanel').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="form-label">Service</label>
                <select name="service_id" class="form-select">
                    <option value="">All Services</option>
                    @foreach($services as $id => $name)
                    <option value="{{ $id }}" {{ request('service_id')==$id?'selected':'' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Date Range</label>
                <input type="text" name="date_range" value="{{ request('date_range') }}" placeholder="Select Date Range" class="form-input" id="dateRangePicker">
            </div>
            <div>
                <label class="form-label">Customer</label>
                <select name="customer_id" class="form-select">
                    <option value="">All Customers</option>
                    @foreach($customers as $id => $email)
                    <option value="{{ $id }}" {{ request('customer_id')==$id?'selected':'' }}>{{ $email }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Handyman</label>
                <select name="handyman_id" class="form-select">
                    <option value="">All Handyman</option>
                    @foreach($handymen as $id => $email)
                    <option value="{{ $id }}" {{ request('handyman_id')==$id?'selected':'' }}>{{ $email }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Booking Status --}}
        <div>
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Booking Status</p>
            <div class="flex flex-wrap gap-2">
                @foreach(['pending','accepted','ongoing','in_progress','hold','cancelled','rejected','failed','completed','pending_approval','waiting'] as $s)
                <label class="cursor-pointer">
                    <input type="radio" name="status" value="{{ $s }}" class="hidden peer" {{ request('status')===$s?'checked':'' }}>
                    <span class="px-3 py-1.5 rounded-full border text-xs font-medium peer-checked:bg-primary-600 peer-checked:text-white peer-checked:border-primary-600 border-gray-300 text-gray-600 hover:border-primary-400 transition-all">
                        {{ ucwords(str_replace('_',' ',$s)) }}
                    </span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Payment Status --}}
        <div>
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Payment Status</p>
            <div class="flex flex-wrap gap-2">
                @foreach(['paid','advanced_paid','advance_refund'] as $s)
                <label class="cursor-pointer">
                    <input type="radio" name="payment_status" value="{{ $s }}" class="hidden peer" {{ request('payment_status')===$s?'checked':'' }}>
                    <span class="px-3 py-1.5 rounded-full border text-xs font-medium peer-checked:bg-primary-600 peer-checked:text-white peer-checked:border-primary-600 border-gray-300 text-gray-600 hover:border-primary-400 transition-all">
                        {{ ucwords(str_replace('_',' ',$s)) }}
                    </span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Payment Type --}}
        <div>
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Payment Type</p>
            <div class="flex flex-wrap gap-2">
                @foreach(['cash','stripe','razorpay','flutterwave','wallet'] as $t)
                <label class="cursor-pointer">
                    <input type="radio" name="payment_type" value="{{ $t }}" class="hidden peer" {{ request('payment_type')===$t?'checked':'' }}>
                    <span class="px-3 py-1.5 rounded-full border text-xs font-medium peer-checked:bg-primary-600 peer-checked:text-white peer-checked:border-primary-600 border-gray-300 text-gray-600 hover:border-primary-400 transition-all">
                        {{ ucfirst($t) }}
                    </span>
                </label>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-2">
            <a href="{{ route('admin.bookings.index') }}" class="btn-secondary text-xs"><i class="fas fa-times"></i> Reset All</a>
            <button type="submit" class="btn-primary text-xs"><i class="fas fa-filter"></i> Apply</button>
        </div>
    </form>
</div>

{{-- Table --}}
<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="data-table w-full">
            <thead>
                <tr>
                    <th class="w-10"><input type="checkbox" class="rounded" id="selectAll"></th>
                    <th>ID</th>
                    <th>Service</th>
                    <th>Booking Date</th>
                    <th>User</th>
                    <th>Shop</th>
                    <th>Provider</th>
                    <th>Status</th>
                    <th>Total Amount</th>
                    <th>Payment Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr>
                    <td><input type="checkbox" class="rounded row-check" value="{{ $booking->id }}"></td>
                    <td class="font-semibold text-primary-600">#{{ $booking->id }}</td>
                    <td>
                        <div class="flex items-center gap-2">
                            <img src="{{ $booking->service->image_url }}" class="w-8 h-8 rounded-lg object-cover" alt="">
                            <span class="text-xs font-medium line-clamp-1 max-w-28">{{ $booking->service->name }}</span>
                        </div>
                    </td>
                    <td class="text-xs text-gray-500">{{ $booking->booking_date->format('M d, Y') }}<br>{{ $booking->booking_date->format('g:i A') }}</td>
                    <td>
                        <div class="flex items-center gap-2">
                            <img src="{{ $booking->customer->profile_image_url }}" class="w-7 h-7 rounded-full" alt="">
                            <div>
                                <p class="text-xs font-medium">{{ $booking->customer->full_name }}</p>
                                <p class="text-xs text-gray-400">{{ $booking->customer->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($booking->shop)
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 bg-gray-200 rounded-full flex items-center justify-center">
                                <i class="fas fa-store text-gray-500 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-xs font-medium">{{ $booking->shop->name }}</p>
                                <p class="text-xs text-gray-400">{{ $booking->shop->email }}</p>
                            </div>
                        </div>
                        @else
                        <span class="text-gray-400 text-xs">-</span>
                        @endif
                    </td>
                    <td>
                        <div class="flex items-center gap-2">
                            <img src="{{ $booking->provider->profile_image_url }}" class="w-7 h-7 rounded-full" alt="">
                            <div>
                                <p class="text-xs font-medium">{{ $booking->provider->full_name }}</p>
                                <p class="text-xs text-gray-400">{{ $booking->provider->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td>
                        @php $sc=['completed'=>'badge-success','pending'=>'badge-warning','cancelled'=>'badge-danger','accepted'=>'badge-info','in_progress'=>'badge-info','rejected'=>'badge-danger']; @endphp
                        <span class="badge {{ $sc[$booking->status] ?? 'badge-pending' }}">
                            {{ ucwords(str_replace('_',' ',$booking->status)) }}
                        </span>
                    </td>
                    <td class="font-semibold text-gray-900 dark:text-white">${{ number_format($booking->total_amount,2) }}</td>
                    <td>
                        @php $pc=['paid'=>'badge-success','pending'=>'badge-warning','failed'=>'badge-danger']; @endphp
                        <span class="badge {{ $pc[$booking->payment_status] ?? 'badge-pending' }}">
                            {{ ucwords(str_replace('_',' ',$booking->payment_status)) }}
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center gap-1">
                            <a href="{{ route('admin.bookings.show',$booking) }}" class="p-1.5 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors" title="View">
                                <i class="fas fa-eye text-xs"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.bookings.destroy',$booking) }}" id="del-{{ $booking->id }}">
                                @csrf @method('DELETE')
                                <button type="button" onclick="confirmDelete('del-{{ $booking->id }}')"
                                        class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="text-center py-12 text-gray-400">
                        <i class="fas fa-calendar-times text-4xl mb-3 block"></i>
                        No bookings found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="flex items-center justify-between px-5 py-4 border-t border-gray-100 dark:border-gray-700">
        <p class="text-sm text-gray-500">
            Display 
            <select class="border rounded px-1 py-0.5 text-xs mx-1 dark:bg-gray-700 dark:border-gray-600">
                <option>10</option><option>25</option><option>50</option>
            </select>
            entries — {{ $bookings->firstItem() }} to {{ $bookings->lastItem() }} of {{ $bookings->total() }} entries
        </p>
        {{ $bookings->links() }}
    </div>
</div>

{{-- ─── Export Modal ───────────────────────────────────────────────────────── --}}
<div id="exportModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-white dark:bg-gray-800 rounded-2xl w-full max-w-md p-6 shadow-2xl">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-bold text-gray-900 dark:text-white">Export Data</h3>
            <button onclick="document.getElementById('exportModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="mb-4">
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select File Type</p>
            <div class="flex flex-wrap gap-2">
                @foreach(['XLSX','XLS','ODS','CSV','PDF','HTML'] as $ft)
                <label class="cursor-pointer">
                    <input type="radio" name="file_type" value="{{ $ft }}" class="hidden peer" {{ $ft==='XLSX'?'checked':'' }}>
                    <span class="px-4 py-2 rounded-lg border text-sm font-medium peer-checked:bg-primary-600 peer-checked:text-white peer-checked:border-primary-600 border-gray-300 text-gray-600 hover:border-primary-400 transition-all">
                        {{ $ft }}
                    </span>
                </label>
                @endforeach
            </div>
        </div>

        <div class="mb-5">
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select Columns</p>
            <div class="space-y-2">
                @foreach(['ID','Service','Booking Date','User','Provider','Status','Total Amount','Payment Status'] as $col)
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" checked class="rounded text-primary-600">
                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ $col }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <button onclick="document.getElementById('exportModal').classList.add('hidden')" class="btn-secondary">Cancel</button>
            <button class="btn-primary"><i class="fas fa-download"></i> Export</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Select all
document.getElementById('selectAll').addEventListener('change', function(){
    document.querySelectorAll('.row-check').forEach(c => c.checked = this.checked);
});
</script>
@endpush
