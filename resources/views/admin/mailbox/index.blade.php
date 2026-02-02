@extends('admin.layouts.app')

@section('title', 'Mail Kutusu')
@section('page-title', 'Mail Kutusu')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600">Dashboard</a>
    <span>/</span>
    <span>Mail Kutusu</span>
@endsection

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Gelen Kutusu -->
        <a href="{{ route('admin.mailbox.inbox') }}" class="bg-white rounded-xl shadow-sm border-2 border-gray-200 hover:border-red-500 p-8 transition-all hover:shadow-md group">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900 group-hover:text-red-600 transition-colors">Gelen Kutusu</h3>
                    <p class="text-sm text-gray-600 mt-1">Aldığınız e-postalar</p>
                </div>
            </div>
        </a>

        <!-- Giden Kutusu -->
        <a href="{{ route('admin.mailbox.sent') }}" class="bg-white rounded-xl shadow-sm border-2 border-gray-200 hover:border-red-500 p-8 transition-all hover:shadow-md group">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900 group-hover:text-red-600 transition-colors">Giden Kutusu</h3>
                    <p class="text-sm text-gray-600 mt-1">Gönderdiğiniz e-postalar</p>
                </div>
            </div>
        </a>

        <!-- Silinen Kutusu -->
        <a href="{{ route('admin.mailbox.trash') }}" class="bg-white rounded-xl shadow-sm border-2 border-gray-200 hover:border-red-500 p-8 transition-all hover:shadow-md group">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900 group-hover:text-red-600 transition-colors">Silinen Kutusu</h3>
                    <p class="text-sm text-gray-600 mt-1">Silinen e-postalar</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Info -->
    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-xl p-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h4 class="text-sm font-bold text-blue-900 mb-2">📧 Hostinger Mail Kutusu</h4>
                <p class="text-sm text-blue-700 leading-relaxed">
                    Bu bölümden Hostinger mail hesabınızdaki e-postaları görüntüleyebilirsiniz. 
                    Gelen kutusu, giden kutusu ve silinen kutusu arasında gezinebilir, mail içeriklerini okuyabilirsiniz.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
