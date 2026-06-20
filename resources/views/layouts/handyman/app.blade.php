<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    @stack('styles')
</head>

<body class="bg-gray-100 overflow-x-hidden">

<div class="flex min-h-screen w-full overflow-hidden">

    @include('handyman.partials.sidebar')

    <div class="flex-1 min-w-0 overflow-hidden">

        @include('handyman.partials.header')

        <main class="p-4 sm:p-6 w-full max-w-full overflow-hidden">
            @yield('content')
        </main>

    </div>

</div>

@stack('scripts')
</body>
</html>