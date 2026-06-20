@extends('layouts.handyman.app')

@section('title','Handyman Dashboard')
@section('page_title','Dashboard')

@section('content')

<div class="space-y-8">

    {{-- Welcome Card --}}
    <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-700 rounded-3xl p-6 sm:p-8 text-white shadow-xl">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <p class="text-indigo-100 text-sm">Welcome back,</p>
                <h2 class="text-2xl sm:text-3xl font-bold mt-1">
                    {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                </h2>
                <p class="text-indigo-100 mt-2 text-sm sm:text-base">
                    Here is your latest booking and earning summary.
                </p>
            </div>

            <div class="bg-white/15 rounded-2xl px-5 py-4 backdrop-blur">
                <p class="text-sm text-indigo-100">Wallet Balance</p>
                <h3 class="text-2xl font-bold mt-1">
                    ₹{{ number_format(auth()->user()->wallet_amount ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Booking</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalBooking ?? 0 }}</h3>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center">
                    <i class="fas fa-calendar-check text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Complete Booking</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $completeBooking ?? 0 }}</h3>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-green-100 text-green-600 flex items-center justify-center">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Remaining Payout</p>
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 mt-2">
                        ₹{{ number_format($remainingPayout ?? 0, 2) }}
                    </h3>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-orange-100 text-orange-600 flex items-center justify-center">
                    <i class="fas fa-hourglass-half text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Revenue</p>
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 mt-2">
                        ₹{{ number_format($totalRevenue ?? 0, 2) }}
                    </h3>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center">
                    <i class="fas fa-wallet text-xl"></i>
                </div>
            </div>
        </div>

    </div>

    {{-- Calendar --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Booking Calendar</h2>
                <p class="text-gray-500 text-sm mt-1">Track your assigned bookings by date.</p>
            </div>

            <a href="{{ route('handyman.dashboard') }}"
               class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700">
                <i class="fas fa-calendar-day"></i>
                Today
            </a>
        </div>

        <div class="w-full overflow-hidden">
            <div id="calendar" class="w-full"></div>
        </div>
    </div>

</div>

@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">

<style>
    .fc {
        font-family: Inter, system-ui, sans-serif;
    }

    .fc .fc-toolbar-title {
        font-size: 22px;
        font-weight: 700;
        color: #111827;
    }

    .fc .fc-button-primary {
        background: #4f46e5;
        border-color: #4f46e5;
        border-radius: 10px;
        padding: 8px 14px;
        font-weight: 600;
    }

    .fc .fc-button-primary:hover {
        background: #4338ca;
        border-color: #4338ca;
    }

    .fc .fc-daygrid-day-number {
        color: #374151;
        font-weight: 600;
    }

    .fc .fc-col-header-cell-cushion {
        color: #4f46e5;
        font-weight: 700;
    }

    @media (max-width: 640px) {
        .fc .fc-toolbar {
            flex-direction: column;
            gap: 12px;
        }

        .fc .fc-toolbar-title {
            font-size: 18px;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');

    if (!calendarEl) return;

    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 650,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        events: [
            @foreach($calendarBookings ?? [] as $booking)
                {
                    title: 'Booking #{{ $booking->id }}',
                    start: '{{ $booking->booking_date }}',
                    backgroundColor: '#4f46e5',
                    borderColor: '#4f46e5',
                    textColor: '#ffffff'
                },
            @endforeach
        ]
    });

    calendar.render();
});
</script>
@endpush