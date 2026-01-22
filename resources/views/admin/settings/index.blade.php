@extends('admin.layouts.app')

@section('title', 'Sistem Ayarları - Admin Panel')
@section('page-title', 'Sistem Ayarları')
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600">Dashboard</a>
    <span>/</span>
    <span>Ayarlar</span>
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900">Sistem Ayarları</h1>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Genel Bilgiler -->
            <div class="space-y-6">
                <h2 class="text-xl font-semibold text-gray-900 border-b pb-2">Genel Bilgiler</h2>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Site Başlığı</label>
                    <input type="text" name="site_title" value="{{ \App\Models\Setting::get('site_title', 'GMSGARAGE') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Footer Metni</label>
                    <textarea name="footer_text" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">{{ \App\Models\Setting::get('footer_text', 'GMSGARAGE © 2026 - Premium Oto Galeri') }}</textarea>
                </div>
            </div>

            <!-- Sosyal Medya -->
            <div class="space-y-6">
                <h2 class="text-xl font-semibold text-gray-900 border-b pb-2">Sosyal Medya</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Instagram</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">instagram.com/</span>
                            <input type="text" name="social_instagram" value="{{ \App\Models\Setting::get('social_instagram', 'gmsgarage') }}"
                                   class="flex-1 px-4 py-2 border border-gray-300 rounded-none rounded-r-lg focus:ring-2 focus:ring-primary-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Facebook</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">facebook.com/</span>
                            <input type="text" name="social_facebook" value="{{ \App\Models\Setting::get('social_facebook', 'gmsgarage') }}"
                                   class="flex-1 px-4 py-2 border border-gray-300 rounded-none rounded-r-lg focus:ring-2 focus:ring-primary-500">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t flex justify-end">
            <button type="submit" class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-bold transition-colors">
                Ayarları Kaydet
            </button>
        </div>
    </form>
</div>
@endsection
