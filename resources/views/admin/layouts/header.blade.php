<header class="bg-white border-b border-gray-200 px-6 py-4">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">@yield('page-title', 'Dashboard')</h1>
            @hasSection('breadcrumb')
                <nav class="mt-1 flex items-center space-x-2 text-sm text-gray-600">
                    @yield('breadcrumb')
                </nav>
            @endif
        </div>
    </div>
</header>
