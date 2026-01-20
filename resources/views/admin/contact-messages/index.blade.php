@extends('admin.layouts.app')

@section('title', 'İletişim Mesajları - Admin Panel')
@section('page-title', 'İletişim Mesajları')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">İletişim Mesajları</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Gelen iletişim mesajlarını görüntüleyin ve yönetin</p>
        </div>
        <div class="flex items-center gap-3 flex-wrap">
            @if($messages->count() > 0)
            <form action="{{ route('admin.contact-messages.destroy-all') }}" method="POST" 
                  onsubmit="return confirm('TÜM mesajları silmek istediğinize emin misiniz? Bu işlem geri alınamaz!');"
                  class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 dark:bg-red-600 dark:hover:bg-red-700 text-white rounded-lg font-semibold transition-all duration-200 inline-flex items-center space-x-2 shadow-sm hover:shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    <span>Tümünü Sil</span>
                </button>
            </form>
            @endif
            <a href="{{ \App\Models\Setting::get('contact_mail_hostinger_link', 'https://mail.hostinger.com/v2/mailboxes/INBOX') }}" 
               target="_blank"
               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-700 text-white rounded-lg font-semibold transition-all duration-200 inline-flex items-center space-x-2 shadow-sm hover:shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
                <span>Mail Paneline Git</span>
            </a>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg p-4 flex items-center space-x-3">
        <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
        </svg>
        <span class="text-green-800 dark:text-green-300">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Stats Cards - All in same style -->
    @if($messages->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Toplam Mesaj -->
        <div class="bg-gradient-to-br from-red-500 to-red-600 dark:from-red-600 dark:to-red-700 rounded-xl p-5 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 dark:text-red-200 text-xs font-medium mb-1.5">Toplam Mesaj</p>
                    <p class="text-2xl font-bold">{{ $messages->total() }}</p>
                </div>
                <div class="bg-white/20 dark:bg-white/30 rounded-lg p-2.5">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <!-- Okunmamış -->
        <div class="bg-gradient-to-br from-red-500 to-red-600 dark:from-red-600 dark:to-red-700 rounded-xl p-5 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 dark:text-red-200 text-xs font-medium mb-1.5">Okunmamış</p>
                    <p class="text-2xl font-bold">{{ $messages->where('is_read', false)->count() }}</p>
                </div>
                <div class="bg-white/20 dark:bg-white/30 rounded-lg p-2.5">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                </div>
            </div>
        </div>
        <!-- Okunmuş -->
        <div class="bg-gradient-to-br from-red-500 to-red-600 dark:from-red-600 dark:to-red-700 rounded-xl p-5 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 dark:text-red-200 text-xs font-medium mb-1.5">Okunmuş</p>
                    <p class="text-2xl font-bold">{{ $messages->where('is_read', true)->count() }}</p>
                </div>
                <div class="bg-white/20 dark:bg-white/30 rounded-lg p-2.5">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Messages List -->
    <div class="bg-white dark:bg-[#252525] rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
        @if($messages->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-[#2a2a2a]">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Gönderen</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">İletişim</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Konu</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Tarih</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Durum</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">İşlemler</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-[#252525] divide-y divide-gray-200 dark:divide-gray-800">
                    @foreach($messages as $message)
                    <tr class="hover:bg-gray-50 dark:hover:bg-[#2a2a2a] transition-all duration-150 {{ !$message->is_read ? 'bg-blue-50/50 dark:bg-blue-900/10 border-l-4 border-blue-500 dark:border-blue-600' : '' }}">
                        <td class="px-4 py-3">
                            <div class="min-w-0">
                                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100 truncate">{{ $message->name }}</div>
                                @if($message->phone)
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $message->phone }}</div>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <a href="mailto:{{ $message->email }}" class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 font-medium inline-flex items-center space-x-1.5">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span class="truncate max-w-[180px]">{{ $message->email }}</span>
                            </a>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm text-gray-900 dark:text-gray-100 font-medium truncate">
                                {{ $message->subject ?? 'Konu yok' }}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 line-clamp-1">
                                {{ \Illuminate\Support\Str::limit($message->message, 45) }}
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-gray-100 font-medium">
                                {{ $message->created_at->format('d.m.Y') }}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $message->created_at->format('H:i') }}
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center">
                            @if($message->is_read)
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300 border border-green-200 dark:border-green-800">
                                Okundu
                            </span>
                            @else
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300 border border-red-200 dark:border-red-800">
                                <span class="w-1.5 h-1.5 bg-red-500 dark:bg-red-400 rounded-full mr-1.5 animate-pulse"></span>
                                Yeni
                            </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('admin.contact-messages.show', $message->id) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 dark:bg-primary-600 dark:hover:bg-primary-700 text-white text-sm font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Görüntüle
                                </a>
                                <form action="{{ route('admin.contact-messages.destroy', $message->id) }}" 
                                      method="POST" 
                                      class="inline"
                                      onsubmit="return confirm('Bu mesajı silmek istediğinize emin misiniz?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center px-3 py-2 bg-yellow-500 hover:bg-yellow-600 dark:bg-yellow-500 dark:hover:bg-yellow-600 text-white rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-16">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-800 mb-4">
                <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Henüz mesaj yok</h3>
            <p class="text-gray-500 dark:text-gray-400">İletişim formundan gelen mesajlar burada görünecek.</p>
        </div>
        @endif

        <!-- Pagination -->
        @if($messages->hasPages())
        <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-[#2a2a2a]">
            {{ $messages->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
