<!DOCTYPE html>
<html lang="tr" id="html-root">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - GMSGARAGE')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        /* Admin Panel Ferah Layout */
        /* xl: 1400px */
        @media (min-width: 1366px) {
            .admin-content-wrapper {
                max-width: 1400px;
                margin: 0 auto;
                padding-left: 2rem;
                padding-right: 2rem;
            }
        }
        
        /* 2xl: 1600px (2K/4K için) */
        @media (min-width: 1536px) {
            .admin-content-wrapper {
                max-width: 1600px;
            }
        }
        
        /* 1366px altında normal akış - minimum padding koru */
        @media (max-width: 1365px) {
            .admin-content-wrapper {
                max-width: 100%;
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }
        
        /* Mobilde padding azalt */
        @media (max-width: 640px) {
            .admin-content-wrapper {
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }
        }
        
        /* Tablo satır yüksekliği - sadece admin-table class'ı olan tablolar için */
        .admin-table thead th {
            padding-top: 1.25rem;
            padding-bottom: 1.25rem;
        }
        
        .admin-table tbody td {
            padding-top: 1.25rem;
            padding-bottom: 1.25rem;
        }
        
        /* Form boşlukları */
        .admin-form-group {
            margin-bottom: 1.5rem;
        }
        
        .admin-form-label {
            margin-bottom: 0.75rem;
            display: block;
        }
        
        /* Grid gap artırma */
        .admin-grid {
            gap: 1.5rem;
        }
        
        @media (min-width: 1024px) {
            .admin-grid {
                gap: 2rem;
            }
        }
        
        /* Section margin */
        .admin-section {
            margin-bottom: 2rem;
        }
        
        @media (min-width: 1024px) {
            .admin-section {
                margin-bottom: 2.5rem;
            }
        }
        
        /* Kartlar arası boşluk */
        .admin-card-spacing {
            margin-bottom: 1.5rem;
        }
        
        @media (min-width: 1024px) {
            .admin-card-spacing {
                margin-bottom: 2rem;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50 admin-body">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        @include('admin.layouts.sidebar')
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            @include('admin.layouts.header')
            
            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6 lg:p-8">
                <div class="admin-content-wrapper">
                    @if(session('success'))
                        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    
    @stack('scripts')
</body>
</html>
