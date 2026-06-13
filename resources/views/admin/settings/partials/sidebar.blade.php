<div class="w-72">

    <div class="bg-white rounded-xl shadow-sm p-4 space-y-2">

        <a href="{{ route('admin.settings.general') }}"
           class="block px-4 py-3 rounded-lg transition
           {{ request()->routeIs('admin.settings.general') ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700' }}">
            General Settings
        </a>

        <a href="{{ route('admin.settings.theme') }}"
           class="block px-4 py-3 rounded-lg transition
           {{ request()->routeIs('admin.settings.theme') ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700' }}">
            Theme Setup
        </a>

        <a href="{{ route('admin.settings.site') }}"
           class="block px-4 py-3 rounded-lg transition
           {{ request()->routeIs('admin.settings.site') ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700' }}">
            Site Setup
        </a>

        <a href="{{ route('admin.settings.service') }}"
           class="block px-4 py-3 rounded-lg transition
           {{ request()->routeIs('admin.settings.service') ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700' }}">
            Service Configuration
        </a>

        <a href="{{ route('admin.settings.app') }}"
           class="block px-4 py-3 rounded-lg transition
           {{ request()->routeIs('admin.settings.app') ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700' }}">
            App Configuration
        </a>

        <a href="{{ route('admin.settings.notification') }}"
           class="block px-4 py-3 rounded-lg transition
           {{ request()->routeIs('admin.settings.notification') ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700' }}">
            Notification Configuration
        </a>

        <a href="{{ route('admin.settings.social') }}"
           class="block px-4 py-3 rounded-lg transition
           {{ request()->routeIs('admin.settings.social') ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700' }}">
            Social Media
        </a>

        <a href="{{ route('admin.settings.payment') }}"
           class="block px-4 py-3 rounded-lg transition
           {{ request()->routeIs('admin.settings.payment') ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700' }}">
            Payment Configuration
        </a>

        <a href="{{ route('admin.settings.mail') }}"
           class="block px-4 py-3 rounded-lg transition
           {{ request()->routeIs('admin.settings.mail') ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700' }}">
            Mail Settings
        </a>

        <a href="{{ route('admin.settings.roles') }}"
           class="block px-4 py-3 rounded-lg transition
           {{ request()->routeIs('admin.settings.roles') ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700' }}">
            Roles & Permission Setup
        </a>

        <a href="{{ route('admin.settings.earning') }}"
           class="block px-4 py-3 rounded-lg transition
           {{ request()->routeIs('admin.settings.earning') ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700' }}">
            Earning Setting
        </a>

        <a href="{{ route('admin.settings.language') }}"
           class="block px-4 py-3 rounded-lg transition
           {{ request()->routeIs('admin.settings.language') ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700' }}">
            Language Setting
        </a>

        <a href="{{ route('admin.settings.banner') }}"
           class="block px-4 py-3 rounded-lg transition
           {{ request()->routeIs('admin.settings.banner') ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700' }}">
            Provider Promotional Banner
        </a>

        <a href="{{ route('admin.settings.seo') }}"
           class="block px-4 py-3 rounded-lg transition
           {{ request()->routeIs('admin.settings.seo') ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700' }}">
            SEO Setting
        </a>

    </div>

</div>