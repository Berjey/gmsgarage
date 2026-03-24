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
<div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
    <a href="{{ route('admin.contact-messages.index', ['filter' => 'all'] + request()->except('filter')) }}"
       class="bg-white rounded-xl p-5 border-2 {{ $filter === 'all' ? 'border-primary-100' : 'border-gray-100' }} shadow-sm hover:border-primary-300 transition-all cursor-pointer group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Toplam Mesaj</p>
                <p class="text-3xl font-bold {{ $filter === 'all' ? 'text-primary-600' : 'text-gray-900 group-hover:text-primary-600' }} transition-colors">{{ $totalCount }}</p>
            </div>
            <div class="w-12 h-12 bg-primary-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>
    </a>
    <a href="{{ route('admin.contact-messages.index', ['filter' => 'unread'] + request()->except('filter')) }}"
       class="bg-white rounded-xl p-5 border-2 {{ $filter === 'unread' ? 'border-blue-400 ring-2 ring-blue-100' : 'border-gray-100' }} shadow-sm hover:border-blue-300 transition-all cursor-pointer group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Okunmamış</p>
                <p class="text-3xl font-bold {{ $filter === 'unread' ? 'text-blue-600' : 'text-gray-900 group-hover:text-blue-600' }} transition-colors">{{ $unreadCount }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
            </div>
        </div>
    </a>
    <a href="{{ route('admin.contact-messages.index', ['filter' => 'read'] + request()->except('filter')) }}"
       class="bg-white rounded-xl p-5 border-2 {{ $filter === 'read' ? 'border-green-400 ring-2 ring-green-100' : 'border-gray-100' }} shadow-sm hover:border-green-300 transition-all cursor-pointer group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Okunmuş</p>
                <p class="text-3xl font-bold {{ $filter === 'read' ? 'text-green-600' : 'text-gray-900 group-hover:text-green-600' }} transition-colors">{{ $readCount }}</p>
            </div>
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </a>
</div>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <!-- Başlık -->
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
                <p class="text-sm text-gray-600 mt-2">Toplam <span class="font-bold text-primary-600">{{ $totalCount }}</span> mesaj kayıtlı</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.contact-messages.export', request()->all()) }}"
                   class="px-5 py-2.5 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-colors flex items-center gap-2 font-semibold shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Excel'e Aktar
                </a>
                <a href="{{ \App\Models\Setting::get('contact_mail_hostinger_link', 'https://mail.hostinger.com/v2/mailboxes/INBOX') }}"
                   target="_blank"
                   class="px-5 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors flex items-center gap-2 font-semibold shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Mail Paneline Git
                </a>
                @if($totalCount > 0)
                <button type="button" onclick="confirmDeleteAll({{ $totalCount }})"
                        class="px-5 py-2.5 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-colors flex items-center gap-2 font-semibold shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Tümünü Sil
                </button>
                <form id="delete-all-form" action="{{ route('admin.contact-messages.destroy-all') }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Arama & Filtre -->
    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
        <form id="filter-form" method="GET" action="{{ route('admin.contact-messages.index') }}" class="flex flex-wrap gap-3 items-center">
            <div class="flex-1 min-w-[250px]">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="🔍 İsim, e-posta veya konu başlığı ara..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
            </div>
            <div class="adm-dd" data-adm-dd data-submit="filter-form" style="width:180px;flex-shrink:0;">
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
            <div class="adm-dd" data-adm-dd data-submit="filter-form" style="width:190px;flex-shrink:0;">
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
            <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors font-medium">
                Filtrele
            </button>
            @if(request('search') || $filter !== 'all' || request('sort') === 'oldest')
            <a href="{{ route('admin.contact-messages.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                Temizle
            </a>
            @endif
        </form>
    </div>

    <!-- Tablo -->
    <div class="overflow-x-auto">
        @if($messages->count() > 0)
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left">
                            <input type="checkbox" id="select-all" class="form-checkbox h-4 w-4 text-primary-600 rounded border-gray-300">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Gönderen</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Konu / Önizleme</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Durum</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tarih</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">İşlemler</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($messages as $message)
                    <tr class="hover:bg-gray-50 transition-colors cursor-pointer {{ !$message->is_read ? 'bg-blue-50/50' : '' }}"
                        onclick="window.location.href='{{ route('admin.contact-messages.show', $message->id) }}'">
                        <td class="px-6 py-4 whitespace-nowrap" onclick="event.stopPropagation()">
                            <input type="checkbox" name="ids[]" value="{{ $message->id }}" class="message-checkbox form-checkbox h-4 w-4 text-primary-600 rounded border-gray-300">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-primary-100 flex items-center justify-center flex-shrink-0">
                                    <span class="text-sm font-bold text-primary-700">{{ strtoupper(mb_substr($message->name, 0, 1)) }}</span>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">{{ $message->name }}</div>
                                    <div class="text-xs text-gray-400">{{ $message->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-gray-900 line-clamp-1 max-w-md">{{ $message->subject ?? 'Konu Yok' }}</div>
                            <div class="text-xs text-gray-400 line-clamp-1 max-w-md">{{ $message->message }}</div>
                        </td>
                        <td class="px-6 py-4 text-center" onclick="event.stopPropagation()">
                            @include('admin.components.message-badge', ['isRead' => $message->is_read])
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $message->created_at->format('d.m.Y') }}
                            <div class="text-xs text-gray-400">{{ $message->created_at->format('H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right" onclick="event.stopPropagation()">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ route('admin.contact-messages.show', $message->id) }}"
                                   class="inline-flex items-center p-1.5 bg-gray-50 text-gray-500 rounded-lg hover:bg-gray-100 transition-colors" title="Görüntüle">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.contact-messages.destroy', $message->id) }}" method="POST" class="inline-block"
                                      onsubmit="return confirmDelete(this, '{{ addslashes($message->name) }} mesajını')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center p-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors" title="Sil">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        <!-- Bulk Actions -->
        <form id="bulk-action-form" method="POST" action="{{ route('admin.contact-messages.bulk-action') }}" class="hidden fixed bottom-8 left-1/2 -translate-x-1/2 bg-white/90 backdrop-blur px-8 py-4 rounded-2xl shadow-2xl border border-primary-100 items-center gap-6 z-50">
            @csrf
            <div id="bulk-hidden-inputs"></div>
            <input type="hidden" name="action" id="bulk-action-type" value="">
            <span id="selected-count" class="text-sm font-bold text-primary-600 uppercase tracking-widest">0 SEÇİLDİ</span>
            <div class="h-8 w-px bg-gray-200"></div>
            <div class="flex items-center gap-2">
                <button type="button" onclick="setBulkAction('mark_read')" class="px-4 py-2 text-sm font-semibold text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors shadow-sm">Okundu Yap</button>
                <button type="button" onclick="setBulkAction('mark_unread')" class="px-4 py-2 text-sm font-semibold text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors shadow-sm">Okunmamış Yap</button>
                <button type="button" onclick="setBulkAction('delete')" class="px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors shadow-sm">Sil</button>
            </div>
        </form>

        <!-- Pagination -->
        @if($messages->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50/50 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-sm text-gray-500">
                <strong>{{ $messages->firstItem() }}–{{ $messages->lastItem() }}</strong> arası gösteriliyor
                (toplam <strong>{{ $messages->total() }}</strong> mesaj)
            </p>
            {{ $messages->links() }}
        </div>
        @endif
        @else
        <div class="p-12 text-center">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                @if(request('search') || $filter !== 'all')
                    Arama sonucu bulunamadı
                @else
                    Henüz mesaj yok
                @endif
            </h3>
            <p class="text-gray-500">
                @if(request('search') || $filter !== 'all')
                    Farklı bir filtre deneyin veya <a href="{{ route('admin.contact-messages.index') }}" class="text-primary-600 hover:underline">tüm mesajları</a> görüntüleyin.
                @else
                    İletişim formundan gelen mesajlar burada görünecek.
                @endif
            </p>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function confirmDeleteAll(totalCount) {
    Swal.fire({
        title: 'Tümünü Silmek İstediğinize Emin Misiniz?',
        html: `<p class="text-gray-600 mb-3">Toplam <strong class="text-red-600">${totalCount} mesaj</strong> kalıcı olarak silinecek.</p>
               <p class="text-sm text-red-500 font-semibold">Bu işlem geri alınamaz!</p>
               <p class="text-sm text-gray-500 mt-3">Onaylamak için aşağıya <strong>SİL</strong> yazın:</p>`,
        input: 'text',
        inputPlaceholder: 'SİL',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Evet, Tümünü Sil',
        cancelButtonText: 'İptal',
        reverseButtons: true,
        customClass: {
            popup: 'rounded-xl shadow-2xl',
            title: 'text-xl font-bold text-gray-900',
            confirmButton: 'px-6 py-3 rounded-lg font-bold shadow-lg',
            cancelButton: 'px-6 py-3 rounded-lg font-bold shadow-sm',
        },
        focusCancel: true,
        preConfirm: (value) => {
            if (value.trim().toUpperCase() !== 'SİL') {
                Swal.showValidationMessage('Lütfen tam olarak <strong>SİL</strong> yazın.');
                return false;
            }
            return true;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Siliniyor...',
                html: 'Tüm mesajlar siliniyor, lütfen bekleyin.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => Swal.showLoading()
            });
            document.getElementById('delete-all-form').submit();
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const checkboxes = document.querySelectorAll('.message-checkbox');
    const bulkForm = document.getElementById('bulk-action-form');
    const countSpan = document.getElementById('selected-count');
    const hiddenContainer = document.getElementById('bulk-hidden-inputs');

    const updateBulkBar = () => {
        const checked = [...checkboxes].filter(cb => cb.checked);
        const count = checked.length;
        bulkForm.classList.toggle('hidden', count === 0);
        bulkForm.classList.toggle('flex', count > 0);
        countSpan.textContent = `${count} SEÇİLDİ`;
        hiddenContainer.innerHTML = '';
        checked.forEach(cb => {
            const inp = document.createElement('input');
            inp.type = 'hidden'; inp.name = 'ids[]'; inp.value = cb.value;
            hiddenContainer.appendChild(inp);
        });
    };

    document.getElementById('select-all')?.addEventListener('change', e => {
        checkboxes.forEach(cb => cb.checked = e.target.checked);
        updateBulkBar();
    });

    checkboxes.forEach(cb => cb.addEventListener('change', updateBulkBar));
});

function setBulkAction(action) {
    const form = document.getElementById('bulk-action-form');
    if (action === 'delete') {
        Swal.fire({
            title: 'Emin misiniz?',
            text: 'Seçili mesajlar kalıcı olarak silinecek.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Evet, Sil',
            cancelButtonText: 'İptal',
            reverseButtons: true,
            customClass: { popup: 'rounded-xl', confirmButton: 'rounded-lg px-6 py-2.5 font-semibold', cancelButton: 'rounded-lg px-6 py-2.5 font-semibold' }
        }).then(r => {
            if (r.isConfirmed) {
                document.getElementById('bulk-action-type').value = action;
                form.submit();
            }
        });
        return;
    }
    document.getElementById('bulk-action-type').value = action;
    form.submit();
}
</script>
@endpush
@endsection
