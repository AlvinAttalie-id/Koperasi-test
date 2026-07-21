<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - {{ config('app.name', 'KSP Nusantara') }}</title>

    <!-- Scripts / Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('styles')
</head>
<body class="h-full text-gray-900 antialiased" x-data="{ collapsed: false, mobileOpen: false }">
    <div class="min-h-screen bg-gray-50 flex">
        <!-- Sidebar component -->
        <x-sidebar />

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-h-screen transition-all duration-300"
             :class="collapsed ? 'lg:pl-16' : 'lg:pl-64'">
            
            <!-- Navbar component -->
            <x-navbar :title="$title ?? 'Dashboard'" :breadcrumb="$breadcrumb ?? []" />

            <!-- Main Page Content -->
            <main class="flex-1 p-4 lg:p-6 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Toast Notifications -->
    <x-toast />

    <!-- Loading Overlay -->
    <x-loading-overlay />

    @stack('scripts')
</body>
</html>
