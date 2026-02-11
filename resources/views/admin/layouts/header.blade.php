<!-- Header Removed - Breadcrumb only if needed -->
@hasSection('breadcrumb')
<header class="bg-white border-b border-gray-200 px-6 py-3">
    <nav class="flex items-center space-x-2 text-sm text-gray-600">
        @yield('breadcrumb')
    </nav>
</header>
@endif
