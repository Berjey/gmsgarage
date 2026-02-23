@extends('admin.layouts.app')

@section('title', 'İletişim Mesajları - Admin Panel')
@section('page-title', 'İletişim Mesajları')
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600">Dashboard</a>
    <span>/</span>
    <span>İletişim</span>
@endsection

@section('content')

<!-- İstatistik Kartları -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <a href="{{ route('admin.contact-messages.index', ['filter' => 'all'] + request()->except('filter')) }}"
       class="bg-white rounded-xl p-6 border-2 {{ $filter === 'all' ? 'border-primary-500 shadow-lg shadow-primary-500/10' : 'border-gray-100' }} shadow-sm hover:shadow-lg hover:border-primary-300 transition-all cursor-pointer group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium mb-1">Toplam Mesaj</p>
                <p class="text-3xl font-bold {{ $filter === 'all' ? 'text-primary-600' : 'text-gray-900 group-hover:text-primary-600' }} transition-colors">{{ $totalCount }}</p>
            </div>
            <div class="w-14 h-14 bg-primary-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.contact-messages.index', ['filter' => 'unread'] + request()->except('filter')) }}"
       class="bg-white rounded-xl p-6 border-2 {{ $filter === 'unread' ? 'border-orange-400 shadow-lg shadow-orange-500/10' : 'border-gray-100' }} shadow-sm hover:shadow-lg hover:border-orange-300 transition-all cursor-pointer group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium mb-1">Okunmamış</p>
                <p class="text-3xl font-bold {{ $filter === 'unread' ? 'text-orange-500' : 'text-gray-900 group-hover:text-orange-500' }} transition-colors">{{ $unreadCount }}</p>
            </div>
            <div class="w-14 h-14 bg-orange-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.contact-messages.index', ['filter' => 'read'] + request()->except('filter')) }}"
       class="bg-white rounded-xl p-6 border-2 {{ $filter === 'read' ? 'border-green-400 shadow-lg shadow-green-500/10' : 'border-gray-100' }} shadow-sm hover:shadow-lg hover:border-green-300 transition-all cursor-pointer group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium mb-1">Okunmuş</p>
                <p class="text-3xl font-bold {{ $filter === 'read' ? 'text-green-600' : 'text-gray-900 group-hover:text-green-600' }} transition-colors">{{ $readCount }}</p>
            </div>
            <div class="w-14 h-14 bg-green-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </a>
</div>

<!-- Ana İçerik -->
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <!-- Header -->
    <div class="p-6 border-b border-gray-200">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                    <div class="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    İletişim Mesajları
                </h2>
                <p class="text-sm text-gray-600 mt-2">Toplam <span class="font-bold text-primary-600">{{ $totalCount }}</span> mesaj • <span class="font-bold text-orange-500">{{ $unreadCount }}</span> okunmamış</p>
            </div>
            <a href="{{ \App\Models\Setting::get('contact_mail_hostinger_link', 'https://mail.hostinger.com/v2/mailboxes/INBOX') }}"
               target="_blank"
               class="px-6 py-2.5 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Mail Paneline Git
            </a>
        </div>
    </div>

    <!-- Filtreler -->
    <div class="p-6 border-b border-gray-200 bg-gray-50">
        <form id="filter-form" method="GET" action="{{ route('admin.contact-messages.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
                    <!-- [PATCH #4.2] Search Input -->
                    <div class="lg:col-span-2">
                        <div class="admin-search-wrapper group">
                            <div class="admin-search-icon">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="İsim, e-posta veya konu başlığı ara..." 
                                   class="admin-search-input">
                        </div>
                    </div>

                    <!-- Durum Filtresi -->
                    <div class="adm-dd" data-adm-dd data-submit="filter-form">
                        <input type="hidden" name="filter" value="{{ $filter }}">
                        <button type="button" class="adm-dd-btn" data-adm-trigger>
                            <span data-adm-label>{{ $filter === 'unread' ? 'Okunmamış' : ($filter === 'read' ? 'Okunmuş' : 'Tüm Mesajlar') }}</span>
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <ul class="adm-dd-list" data-adm-list>
                            <li data-value="all"    class="{{ $filter === 'all'    ? 'selected' : '' }}">Tüm Mesajlar</li>
                            <li data-value="unread" class="{{ $filter === 'unread' ? 'selected' : '' }}">Okunmamış</li>
                            <li data-value="read"   class="{{ $filter === 'read'   ? 'selected' : '' }}">Okunmuş</li>
                        </ul>
                    </div>

                    <!-- Sıralama -->
                    <div class="adm-dd" data-adm-dd data-submit="filter-form">
                        <input type="hidden" name="sort" value="{{ request('sort', 'newest') }}">
                        <button type="button" class="adm-dd-btn" data-adm-trigger>
                            <span data-adm-label>{{ request('sort') === 'oldest' ? 'Eskiden Yeniye' : 'Yeniden Eskiye' }}</span>
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <ul class="adm-dd-list" data-adm-list>
                            <li data-value="newest" class="{{ request('sort') !== 'oldest' ? 'selected' : '' }}">Yeniden Eskiye</li>
                            <li data-value="oldest" class="{{ request('sort') === 'oldest' ? 'selected' : '' }}">Eskiden Yeniye</li>
                        </ul>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-1">
                    <a href="{{ route('admin.contact-messages.index') }}"
                       class="px-5 py-2 text-sm font-medium text-gray-500 hover:text-red-600 transition-colors">
                        Filtreleri Sıfırla
                    </a>
                </div>
        </form>
    </div>

    <!-- Table Area -->
    <div class="overflow-x-auto">
            @if($messages->count() > 0)
            <form id="bulk-action-form" method="POST" action="{{ route('admin.contact-messages.bulk-action') }}">
                @csrf
                <table class="w-full">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-6 py-4 text-left">
                                <input type="checkbox" id="select-all" class="w-5 h-5 rounded border-gray-300 text-primary-600 focus:ring-primary-500/20 transition-all">
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">GÖNDEREN</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">KONU / ÖNİZLEME</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-widest">DURUM</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-widest">İŞLEMLER</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($messages as $message)
                        <tr class="group hover:bg-gray-50 transition-all cursor-pointer {{ !$message->is_read ? 'bg-primary-50/10' : '' }}"
                            onclick="window.location.href='{{ route('admin.contact-messages.show', $message->id) }}'">
                            <td class="px-6 py-5" onclick="event.stopPropagation()">
                                <input type="checkbox" name="ids[]" value="{{ $message->id }}" class="message-checkbox w-5 h-5 rounded border-gray-300 text-primary-600 focus:ring-primary-500/20 transition-all">
                            </td>
                            <td class="px-6 py-5">
                                <div class="font-bold text-gray-900 group-hover:text-primary-600 transition-colors">{{ $message->name }}</div>
                                <div class="text-sm text-gray-500 font-medium">{{ $message->email }}</div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="font-bold text-gray-800 line-clamp-1 max-w-md">{{ $message->subject ?? 'Konu Yok' }}</div>
                                <div class="text-sm text-gray-400 font-medium line-clamp-1 max-w-md italic">{{ $message->message }}</div>
                            </td>
                            <td class="px-6 py-5 text-center" onclick="event.stopPropagation()">
                                @include('admin.components.message-badge', ['isRead' => $message->is_read])
                            </td>
                            <td class="px-6 py-5 text-right" onclick="event.stopPropagation()">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.contact-messages.show', $message->id) }}" 
                                       class="p-2.5 text-primary-600 bg-primary-50 rounded-xl hover:bg-primary-600 hover:text-white transition-all shadow-sm"
                                       title="Görüntüle">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <button type="button"
                                            onclick="openDeleteModal({{ $message->id }}, '{{ route('admin.contact-messages.destroy', $message->id) }}')"
                                            class="p-2.5 text-red-600 bg-red-50 rounded-xl hover:bg-red-600 hover:text-white transition-all shadow-sm"
                                            title="Sil">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Bulk Actions -->
                <div id="bulk-actions-bar" class="hidden fixed bottom-8 left-1/2 -translate-x-1/2 bg-white/90 backdrop-blur px-8 py-4 rounded-2xl shadow-2xl border border-primary-100 items-center gap-6 z-50 animate-bounce-subtle">
                    <span id="selected-count" class="text-sm font-bold text-primary-600 uppercase tracking-widest">0 SEÇİLDİ</span>
                    <div class="h-8 w-px bg-gray-200"></div>
                    <div class="flex items-center gap-2">
                        <input type="hidden" name="action" id="bulk-action-type" value="">
                        <button type="button" onclick="setBulkAction('mark_read')" class="px-4 py-2 text-sm font-bold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-all shadow-sm">Okundu Yap</button>
                        <button type="button" onclick="setBulkAction('mark_unread')" class="px-4 py-2 text-sm font-bold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-all shadow-sm">Okunmamış Yap</button>
                        <button type="button" onclick="setBulkAction('delete')" class="px-4 py-2 text-sm font-bold text-white bg-red-600 rounded-xl hover:bg-red-700 transition-all shadow-lg shadow-red-500/25">Sil</button>
                    </div>
                </div>
            </form>
            @else
            <div class="text-center py-24">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Henüz mesaj yok</h3>
                <p class="text-gray-600">İletişim formundan gelen mesajlar burada görünecektir.</p>
            </div>
            @endif
        </div>

    <!-- Pagination -->
    @if($messages->hasPages())
    <div class="px-6 py-5 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
        <div class="text-sm font-semibold text-gray-500">
            {{ $messages->firstItem() }}–{{ $messages->lastItem() }} / <span class="text-gray-900">{{ $messages->total() }}</span> mesaj
        </div>
        <div class="flex items-center gap-4">
            <select onchange="window.location.href='{{ request()->fullUrlWithQuery(['per_page' => '__PER_PAGE__', 'page' => 1]) }}'.replace('__PER_PAGE__', this.value)"
                    class="bg-white border border-gray-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all text-sm font-medium">
                <option value="25" {{ request('per_page', 25) == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
            </select>
            {{ $messages->links() }}
        </div>
    </div>
    @endif
</div>

@include('admin.components.confirm-modal', [
    'id' => 'delete-modal',
    'title' => 'Mesajı Sil',
    'message' => 'Bu mesajı silmek istediğinize emin misiniz? Bu işlem geri alınamaz.',
    'confirmText' => 'Sil',
    'cancelText' => 'Vazgeç'
])

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Bulk Selection
        const checkboxes = document.querySelectorAll('.message-checkbox');
        const bulkBar = document.getElementById('bulk-actions-bar');
        const countSpan = document.getElementById('selected-count');

        const updateBulkBar = () => {
            const count = [...checkboxes].filter(cb => cb.checked).length;
            bulkBar.classList.toggle('hidden', count === 0);
            bulkBar.classList.toggle('flex', count > 0);
            countSpan.textContent = `${count} SEÇİLDİ`;
        };

        document.getElementById('select-all')?.addEventListener('change', e => {
            checkboxes.forEach(cb => cb.checked = e.target.checked);
            updateBulkBar();
        });

        checkboxes.forEach(cb => cb.addEventListener('change', updateBulkBar));
    });

    function setBulkAction(action) {
        if (action === 'delete' && !confirm('Seçili tüm mesajları silmek istediğinize emin misiniz?')) return;
        document.getElementById('bulk-action-type').value = action;
        document.getElementById('bulk-action-form').submit();
    }

    function openDeleteModal(id, url) {
        document.getElementById('confirm-form-delete-modal').action = url;
        document.getElementById('delete-modal').classList.remove('hidden');
    }
</script>
@endpush
@endsection
