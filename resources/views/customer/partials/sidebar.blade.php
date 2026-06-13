@php
    $menuItems = [
    [
        'label' => 'Dashboard',
        'icon' => 'fas fa-home',
        'route' => Route::has('customer.dashboard') ? route('customer.dashboard') : '#',
        'active' => request()->routeIs('customer.dashboard'),
    ],
   
    [
        'label' => 'Notifications',
        'icon' => 'far fa-bell',
        'route' => Route::has('customer.notifications') ? route('customer.notifications') : '#',
        'active' => request()->routeIs('customer.notifications*'),
    ],
    [
        'label' => 'My Wallet',
        'icon' => 'fas fa-wallet',
        'route' => Route::has('customer.wallet') ? route('customer.wallet') : '#',
        'active' => request()->routeIs('customer.wallet*'),
    ],
    [
        'label' => 'Saved Addresses',
        'icon' => 'fas fa-map-marker-alt',
        'route' => Route::has('customer.addresses') ? route('customer.addresses') : '#',
        'active' => request()->routeIs('customer.addresses*'),
    ],
    [
        'label' => 'Profile Settings',
        'icon' => 'far fa-user',
        'route' => Route::has('customer.profile') ? route('customer.profile') : '#',
        'active' => request()->routeIs('customer.profile*'),
    ],
    [
        'label' => 'My Reviews',
        'icon' => 'far fa-star',
        'route' => Route::has('customer.reviews') ? route('customer.reviews') : '#',
        'active' => request()->routeIs('customer.reviews*'),
    ],
];
@endphp

<div x-data="{ open: false }" class="lg:w-[300px] shrink-0">

    {{-- Mobile Button --}}
    <button type="button"
            @click="open = true"
            class="lg:hidden mb-5 inline-flex items-center gap-2 px-5 py-3 bg-white rounded-xl shadow-sm text-[#008ee6] font-semibold">
        <i class="fas fa-bars"></i>
        Menu
    </button>

    {{-- Overlay --}}
    <div x-show="open"
         x-cloak
         @click="open = false"
         class="fixed inset-0 bg-black/40 z-40 lg:hidden">
    </div>

    {{-- Sidebar --}}
    <aside
        :class="open ? 'translate-x-0' : '-translate-x-full'"
        class="fixed lg:static top-0 left-0 z-50 lg:z-auto
               w-[300px] h-full lg:h-fit
               bg-white rounded-r-[22px] lg:rounded-[22px]
               shadow-lg lg:shadow-sm p-6
               transform lg:translate-x-0 transition-transform duration-300">

        <div class="flex items-center justify-between mb-6 lg:hidden">
            <h3 class="font-bold text-lg text-[#10213f]">Menu</h3>

            <button type="button"
                    @click="open = false"
                    class="w-9 h-9 rounded-full bg-gray-100">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <nav class="space-y-4">

            @foreach($menuItems as $item)
                <a href="{{ $item['route'] }}"
                   class="flex items-center gap-4 px-5 py-4 rounded-2xl transition
                   {{ $item['active']
                        ? 'bg-[#e0f2ff] border border-[#64bfff] text-[#008ee6] font-medium'
                        : 'text-[#1f3354] hover:bg-[#f2f8ff]' }}">
                    <i class="{{ $item['icon'] }} w-5"></i>
                    {{ $item['label'] }}
                </a>
            @endforeach

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                        class="w-full flex items-center gap-4 px-5 py-4 rounded-2xl text-red-500 hover:bg-red-50">
                    <i class="fas fa-sign-out-alt w-5"></i>
                    Logout
                </button>
            </form>

        </nav>

    </aside>
</div>