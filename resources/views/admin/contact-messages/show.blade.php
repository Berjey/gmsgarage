@extends('admin.layouts.app')

@section('title', 'Mesaj Detayı - Admin Panel')
@section('page-title', 'Mesaj Detayı')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Sticky Header -->
    <div class="sticky top-0 z-10 bg-gray-50/95 dark:bg-[#1e1e1e]/95 backdrop-blur-md -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 py-4 mb-6 border-b border-gray-200 dark:border-gray-800 shadow-sm">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.contact-messages.index') }}" 
                   class="group inline-flex items-center px-4 py-2.5 bg-white dark:bg-[#252525] hover:bg-gray-50 dark:hover:bg-[#2a2a2a] text-gray-700 dark:text-gray-300 rounded-xl font-medium transition-all duration-200 border border-gray-200 dark:border-gray-800 shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    <svg class="w-4 h-4 mr-2 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Geri Dön
                </a>
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100">Mesaj Detayı</h1>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 hidden sm:block">İletişim formundan gelen mesajın detayları</p>
                </div>
            </div>
            <div class="flex items-center gap-3 flex-wrap">
                @if(!$message->is_read)
                <span class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300 rounded-xl text-xs font-semibold border border-red-200 dark:border-red-800 shadow-sm">
                    <span class="w-2 h-2 bg-red-500 dark:bg-red-400 rounded-full mr-2 animate-pulse"></span>
                    Yeni Mesaj
                </span>
                @endif
                <div class="inline-flex items-center px-3 py-1.5 bg-white dark:bg-[#252525] text-gray-700 dark:text-gray-300 rounded-xl text-xs font-medium border border-gray-200 dark:border-gray-800 shadow-sm">
                    <svg class="w-3.5 h-3.5 mr-2 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span class="font-semibold">{{ $message->created_at->format('d.m.Y') }}</span>
                    <span class="mx-2 text-gray-400">•</span>
                    <span>{{ $message->created_at->format('H:i') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="mb-6 bg-green-50 dark:bg-green-900/30 border-l-4 border-green-500 dark:border-green-400 rounded-xl p-4 flex items-start space-x-3 shadow-sm">
        <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
        </svg>
        <span class="text-green-800 dark:text-green-300 text-sm font-medium">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Main Grid: 2 Columns -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Left Column: Message Content + Subject -->
        <div class="space-y-6">
            <div class="bg-white dark:bg-[#252525] rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
                <!-- Card Header -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800 bg-gradient-to-r from-primary-50 to-white dark:from-primary-900/20 dark:to-[#252525]">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-primary-100 dark:bg-primary-900/30 rounded-lg">
                            <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">Mesaj İçeriği</h2>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Gönderilen mesaj ve konu bilgisi</p>
                        </div>
                    </div>
                </div>

                <!-- Card Content -->
                <div class="p-6 space-y-6">
                    <!-- Subject Section -->
                    <div>
                        <div class="flex items-center space-x-2 mb-3">
                            <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Konu</h3>
                        </div>
                        @if($message->subject)
                        <p class="text-base font-semibold text-gray-900 dark:text-gray-100">{{ $message->subject }}</p>
                        @else
                        <p class="text-sm text-gray-400 dark:text-gray-500 italic">(Konu girilmemiş)</p>
                        @endif
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-gray-200 dark:border-gray-800"></div>

                    <!-- Message Content Section -->
                    <div>
                        <div class="flex items-center space-x-2 mb-3">
                            <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Mesaj</h3>
                        </div>
                        <div class="bg-gradient-to-br from-gray-50 to-gray-100/50 dark:from-[#1e1e1e] dark:to-[#1a1a1a] rounded-xl p-5 border border-gray-200 dark:border-gray-700 min-h-[220px] max-h-[500px] overflow-y-auto custom-scrollbar">
                            <div class="prose prose-sm dark:prose-invert max-w-none">
                                <div class="text-sm text-gray-900 dark:text-gray-100 leading-relaxed whitespace-pre-wrap" style="line-height: 1.75; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;">
                                    {{ $message->message }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Contact Info + Actions -->
        <div class="space-y-6">
            <div class="bg-white dark:bg-[#252525] rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
                <!-- Card Header -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800 bg-gradient-to-r from-gray-50 to-white dark:from-[#2a2a2a] dark:to-[#252525]">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">İletişim & Aksiyonlar</h2>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Gönderen bilgileri ve hızlı işlemler</p>
                        </div>
                    </div>
                </div>

                <!-- Card Content -->
                <div class="p-6 space-y-6">
                    <!-- Contact Information Section -->
                    <div>
                        <div class="flex items-center space-x-2 mb-4">
                            <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Gönderen Bilgileri</h3>
                        </div>
                        <div class="space-y-4">
                            <!-- Name -->
                            <div class="flex items-start space-x-3 pb-4 border-b border-gray-200 dark:border-gray-800">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-500 to-primary-600 dark:from-primary-600 dark:to-primary-700 flex items-center justify-center text-white font-bold text-sm shadow-md">
                                        {{ strtoupper(substr($message->name, 0, 1)) }}
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Ad Soyad</p>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100 truncate">{{ $message->name }}</p>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="pb-4 border-b border-gray-200 dark:border-gray-800">
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">E-posta</p>
                                <a href="mailto:{{ $message->email }}" 
                                   class="group inline-flex items-center text-sm font-medium text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 hover:underline break-all focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 rounded px-2 -ml-2 py-1">
                                    <svg class="w-4 h-4 mr-2 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="break-all">{{ $message->email }}</span>
                                </a>
                            </div>

                            <!-- Phone -->
                            @if($message->phone)
                            <div class="pb-4 border-b border-gray-200 dark:border-gray-800">
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Telefon</p>
                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $message->phone) }}" 
                                   class="group inline-flex items-center text-sm font-medium text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 hover:underline focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 rounded px-2 -ml-2 py-1">
                                    <svg class="w-4 h-4 mr-2 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    {{ $message->phone }}
                                </a>
                            </div>
                            @endif

                            <!-- Date -->
                            <div>
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Gönderim Tarihi</p>
                                <div class="flex items-center text-sm text-gray-900 dark:text-gray-100">
                                    <svg class="w-4 h-4 mr-2 text-gray-400 dark:text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <div>
                                        <span class="font-semibold">{{ $message->created_at->format('d.m.Y') }}</span>
                                        <span class="mx-2 text-gray-400 dark:text-gray-500">•</span>
                                        <span class="text-gray-600 dark:text-gray-400">{{ $message->created_at->format('H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-gray-200 dark:border-gray-800"></div>

                    <!-- Quick Actions Section -->
                    <div>
                        <div class="flex items-center space-x-2 mb-4">
                            <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                            </svg>
                            <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Hızlı Aksiyonlar</h3>
                        </div>
                        <div class="space-y-3">
                            <!-- Primary: Mail Paneline Git -->
                            <a href="{{ \App\Models\Setting::get('contact_mail_hostinger_link', 'https://mail.hostinger.com/v2/mailboxes/INBOX') }}" 
                               target="_blank"
                               class="group w-full inline-flex items-center justify-center px-5 py-3.5 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 dark:from-primary-600 dark:to-primary-700 dark:hover:from-primary-700 dark:hover:to-primary-800 text-white rounded-xl font-semibold transition-all duration-200 shadow-md hover:shadow-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transform hover:scale-[1.02]">
                                <svg class="w-5 h-5 mr-2.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                Mail Paneline Git
                            </a>

                            <!-- Secondary: E-posta ile Yanıtla -->
                            <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject ?? 'İletişim Formu' }}" 
                               class="group w-full inline-flex items-center justify-center px-5 py-3.5 bg-white dark:bg-[#2a2a2a] hover:bg-gray-50 dark:hover:bg-[#1e1e1e] text-primary-600 dark:text-primary-400 border-2 border-primary-600 dark:border-primary-500 rounded-xl font-semibold transition-all duration-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transform hover:scale-[1.02]">
                                <svg class="w-5 h-5 mr-2.5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                E-posta ile Yanıtla
                            </a>

                            <!-- Destructive: Mesajı Sil -->
                            <form action="{{ route('admin.contact-messages.destroy', $message->id) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Bu mesajı silmek istediğinize emin misiniz? Bu işlem geri alınamaz.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="group w-full inline-flex items-center justify-center px-5 py-3.5 bg-white dark:bg-[#2a2a2a] hover:bg-red-50 dark:hover:bg-red-900/20 text-red-600 dark:text-red-400 border-2 border-red-300 dark:border-red-800 hover:border-red-400 dark:hover:border-red-700 rounded-xl font-semibold transition-all duration-200 text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transform hover:scale-[1.02]">
                                    <svg class="w-5 h-5 mr-2.5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Mesajı Sil
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom Scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 10px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
        border-radius: 10px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(156, 163, 175, 0.5);
        border-radius: 10px;
        border: 2px solid transparent;
        background-clip: padding-box;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(156, 163, 175, 0.7);
        background-clip: padding-box;
    }
    
    /* Dark Mode Scrollbar */
    .dark .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(75, 85, 99, 0.5);
        background-clip: padding-box;
    }
    
    .dark .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(75, 85, 99, 0.7);
        background-clip: padding-box;
    }
    
    /* Smooth transitions */
    * {
        transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 150ms;
    }
</style>
@endsection
