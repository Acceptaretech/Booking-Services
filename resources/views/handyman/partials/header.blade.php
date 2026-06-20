<div class="bg-white border-b border-gray-200 shadow-sm px-4 lg:px-6 py-4">

    <div class="flex items-center justify-between">

        {{-- Left Side --}}
        <div class="flex items-center gap-4">

            {{-- Mobile Sidebar Toggle --}}
            <button onclick="toggleSidebar()"
                    class="lg:hidden w-10 h-10 rounded-lg bg-indigo-600 text-white flex items-center justify-center">
                <i class="fas fa-bars"></i>
            </button>

            <div>
                <h1 class="text-lg lg:text-2xl font-bold text-gray-900">
                    @yield('page_title')
                </h1>

                <p class="hidden md:block text-sm text-gray-500">
                    Welcome back, {{ auth()->user()->first_name }}
                </p>
            </div>

        </div>

        {{-- Right Side --}}
        <div class="flex items-center gap-3 lg:gap-5">

            {{-- Notification --}}
            <button
                class="relative w-10 h-10 rounded-full bg-gray-100 hover:bg-indigo-50 flex items-center justify-center transition">

                <i class="fas fa-bell text-gray-600"></i>

                <span
                    class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-red-500 border border-white"></span>
            </button>

            <div class="relative" x-data="{ open:false }">

                <button @click="open = !open"
                        class="flex items-center gap-3">
                    <img src="{{ auth()->user()->profile_image ? asset('storage/'.auth()->user()->profile_image) : asset('images/default-user.png') }}"
                         class="w-12 h-12 rounded-full object-cover border-2 border-indigo-500">
            
                    <span class="hidden sm:block font-semibold text-gray-800">
                        {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                    </span>
            
                </button>
            
                <div x-show="open"
                     @click.away="open = false"
                     x-transition
                     class="absolute top-full right-0 mt-2 w-64 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50">
            
                   
            
                    <a href="{{ route('handyman.dashboard') }}"
                       class="flex items-center gap-4 px-5 py-4 hover:bg-gray-50 border-b">
                        <i class="fas fa-home text-indigo-600 w-5"></i>
                        <span>Home</span>
                    </a>
            
                    <a href="{{ route('handyman.profile') }}"
                       class="flex items-center gap-4 px-5 py-4 hover:bg-gray-50 border-b">
                        <i class="far fa-user-circle text-indigo-600 w-5"></i>
                        <span>My Profile</span>
                    </a>
            
                    <a href="{{ route('handyman.profile') }}"
                       class="flex items-center gap-4 px-5 py-4 hover:bg-gray-50 border-b">
                        <i class="fas fa-id-card text-indigo-600 w-5"></i>
                        <span>My Info</span>
                    </a>
            
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center gap-4 px-5 py-4 text-red-500 hover:bg-red-50">
                            <i class="fas fa-sign-out-alt w-5"></i>
                            <span>Log Out</span>
                        </button>
                    </form>
            
                </div>
            </div>
        </div>

    </div>

</div>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>