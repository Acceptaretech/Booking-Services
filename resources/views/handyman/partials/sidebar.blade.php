<aside id="handymanSidebar"
       class="fixed lg:relative inset-y-0 left-0 z-50 w-72 bg-slate-950 text-white min-h-screen transform -translate-x-full lg:translate-x-0 transition-all duration-300 shadow-2xl">

    {{-- Logo --}}
    <div class="p-5 border-b border-slate-800 flex items-center justify-between">

        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center">
                <i class="fas fa-tools text-white text-lg"></i>
            </div>

            <div>
                <h2 class="text-xl font-bold">Technician</h2>
                <p class="text-xs text-slate-400">Technician Panel</p>
            </div>
        </div>

        <button onclick="toggleSidebar()"
                class="lg:hidden text-slate-300">
            <i class="fas fa-times"></i>
        </button>

    </div>

    {{-- Profile --}}
    <div class="p-5 border-b border-slate-800">

        <div class="flex items-center gap-3">

            <img
                src="{{ auth()->user()->profile_image
                    ? asset('storage/'.auth()->user()->profile_image)
                    : asset('images/default-user.png') }}"
                class="w-14 h-14 rounded-full object-cover border-2 border-indigo-500">

            <div>
                <h4 class="font-semibold text-white">
                    {{ auth()->user()->first_name }}
                    {{ auth()->user()->last_name }}
                </h4>

                <p class="text-xs text-slate-400">
                    {{ auth()->user()->email }}
                </p>

                <span class="inline-block mt-2 px-2 py-1 text-[10px] bg-green-500/20 text-green-400 rounded-full">
                    Active Technician
                </span>
            </div>

        </div>

    </div>

    {{-- Navigation --}}
    <div class="p-4">

        <p class="text-xs uppercase text-slate-500 px-3 mb-3 font-semibold">
            Main
        </p>

        <ul class="space-y-2">

            <li>
                <a href="{{ route('handyman.dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
                   {{ request()->routeIs('handyman.dashboard') ? 'bg-indigo-600 text-white shadow-lg' : 'hover:bg-slate-800 text-slate-300' }}">
                    <i class="fas fa-chart-pie w-5"></i>
                    Dashboard
                </a>
            </li>

            <li>
                <a href="{{ route('handyman.bookings.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
                   {{ request()->routeIs('handyman.bookings.*') ? 'bg-indigo-600 text-white shadow-lg' : 'hover:bg-slate-800 text-slate-300' }}">
                    <i class="fas fa-calendar-check w-5"></i>
                    Bookings
                </a>
            </li>

        </ul>

        <p class="text-xs uppercase text-slate-500 px-3 mt-8 mb-3 font-semibold">
            Transactions
        </p>

        <ul class="space-y-2">

            <li>
                <a href="{{ route('handyman.payments.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
                   {{ request()->routeIs('handyman.payments.*') ? 'bg-indigo-600 text-white shadow-lg' : 'hover:bg-slate-800 text-slate-300' }}">
                    <i class="fas fa-wallet w-5"></i>
                    Payments
                </a>
            </li>

        </ul>

        <p class="text-xs uppercase text-slate-500 px-3 mt-8 mb-3 font-semibold">
            Account
        </p>

        <ul class="space-y-2">

            <li>
                <a href="{{ route('handyman.profile') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
                   {{ request()->routeIs('handyman.profile') ? 'bg-indigo-600 text-white shadow-lg' : 'hover:bg-slate-800 text-slate-300' }}">
                    <i class="fas fa-user w-5"></i>
                    Profile
                </a>
            </li>

            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button type="submit"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-400 hover:bg-red-500/20 transition-all">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        Logout
                    </button>
                </form>
            </li>

        </ul>

    </div>

    {{-- Footer --}}
    <div class="absolute bottom-0 left-0 right-0 border-t border-slate-800 p-4">
        <p class="text-center text-xs text-slate-500">
            © {{ date('Y') }} Technician System
        </p>
    </div>

</aside>

{{-- Mobile Overlay --}}
<div id="sidebarOverlay"
     onclick="toggleSidebar()"
     class="fixed inset-0 bg-black/70 z-40 hidden lg:hidden">
</div>

<script>
function toggleSidebar() {
    document.getElementById('handymanSidebar').classList.toggle('-translate-x-full');
    document.getElementById('sidebarOverlay').classList.toggle('hidden');
}
</script>