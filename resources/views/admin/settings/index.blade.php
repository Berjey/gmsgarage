@extends('admin.layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Site Ayarları</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Web sitenizin genel ayarlarını yönetin</p>
        </div>
        <div>
            <a href="{{ route('admin.contact-settings.index') }}" 
               class="inline-flex items-center space-x-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <span>İletişim Ayarları</span>
            </a>
        </div>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" class="bg-white dark:bg-[#252525] rounded-lg shadow-sm border border-gray-200 dark:border-gray-800 p-6">
        @csrf
        @method('PUT')

        @php
            $groups = ['general' => 'Genel Ayarlar', 'seo' => 'SEO Ayarları', 'contact' => 'İletişim Bilgileri', 'social' => 'Sosyal Medya'];
        @endphp

        @foreach($groups as $groupKey => $groupTitle)
            <div class="mb-8 {{ !$loop->first ? 'border-t border-gray-200 dark:border-gray-800 pt-8' : '' }}">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ $groupTitle }}</h2>
                
                @if(isset($settings[$groupKey]))
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($settings[$groupKey] as $setting)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ $setting->description ?? ucfirst(str_replace('_', ' ', $setting->key)) }}
                                </label>
                                <input type="text" 
                                       name="settings[{{ $setting->key }}]" 
                                       value="{{ old('settings.' . $setting->key, $setting->value) }}"
                                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-[#1e1e1e] text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-gray-500 dark:text-gray-400 text-sm">Henüz ayar eklenmemiş</div>
                @endif
            </div>
        @endforeach

        <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200 dark:border-gray-800">
            <button type="submit" class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-medium transition-colors">
                Ayarları Kaydet
            </button>
        </div>
    </form>
</div>
@endsection
