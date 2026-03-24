@extends('admin.layouts.app')

@section('title', 'Değerleme İstekleri - Admin Panel')
@section('page-title', 'Değerleme İstekleri')
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600">Dashboard</a>
    <span>/</span>
    <span>Değerleme İstekleri</span>
@endsection

@section('content')

<!-- İstatistik Kartları -->
<div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl p-5 border-2 border-primary-100 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Toplam Talep</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total'] }}</p>
            </div>
            <div class="w-12 h-12 bg-primary-50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-5 border-2 border-gray-100 shadow-sm hover:border-blue-300 transition-all group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Yeni / Okunmamış</p>
                <p class="text-3xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $stats['new'] }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-5 border-2 border-gray-100 shadow-sm hover:border-green-300 transition-all group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">İncelendi</p>
                <p class="text-3xl font-bold text-gray-900 group-hover:text-green-600 transition-colors">{{ $stats['read'] }}</p>
            </div>
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <!-- Başlık -->
    <div class="p-6 border-b border-gray-200">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                    <div class="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    Değerleme İstekleri
                </h2>
                <p class="text-sm text-gray-600 mt-2">Toplam <span class="font-bold text-primary-600">{{ $stats['total'] }}</span> talep • <span class="font-bold text-blue-600">{{ $stats['new'] }}</span> yeni</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.evaluation-requests.export', request()->query()) }}"
                   class="px-5 py-2.5 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-colors flex items-center gap-2 font-semibold shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Excel'e Aktar
                </a>
                @if($stats['total'] > 0)
                <button type="button" onclick="confirmDeleteAll({{ $stats['total'] }})"
                        class="px-5 py-2.5 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-colors flex items-center gap-2 font-semibold shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Tümünü Sil
                </button>
                <form id="delete-all-form" action="{{ route('admin.evaluation-requests.destroy-all') }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Arama & Filtre -->
    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
        <form id="eval-filter-form" method="GET" action="{{ route('admin.evaluation-requests.index') }}" class="flex flex-wrap gap-3 items-center">
            <div class="flex-1 min-w-[250px]">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="🔍 Ad, e-posta, telefon, marka veya model ara..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
            </div>
            <div class="adm-dd" data-adm-dd data-submit="eval-filter-form" style="width:180px;flex-shrink:0;">
                <input type="hidden" name="status" value="{{ request('status') }}">
                <button type="button" class="adm-dd-btn" data-adm-trigger>
                    <span data-adm-label>
                        @if(request('status') === 'unread') Okunmamış
                        @elseif(request('status') === 'read') Okunmuş
                        @else Tüm Durumlar
                        @endif
                    </span>
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <ul class="adm-dd-list" data-adm-list>
                    <li data-value="" class="{{ !request('status') ? 'selected' : '' }}">Tüm Durumlar</li>
                    <li data-value="unread" class="{{ request('status') === 'unread' ? 'selected' : '' }}">Okunmamış</li>
                    <li data-value="read" class="{{ request('status') === 'read' ? 'selected' : '' }}">Okunmuş</li>
                </ul>
            </div>
            <input type="date" name="date_from" value="{{ request('date_from') }}"
                   class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                   title="Başlangıç tarihi">
            <input type="date" name="date_to" value="{{ request('date_to') }}"
                   class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                   title="Bitiş tarihi">
            <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors font-medium">
                Filtrele
            </button>
            @if(request()->hasAny(['search', 'status', 'date_from', 'date_to']))
            <a href="{{ route('admin.evaluation-requests.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                Temizle
            </a>
            @endif
        </form>
    </div>

    <!-- Tablo -->
    <div class="overflow-x-auto">
        @if($requests->count() > 0)
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left">
                        <input type="checkbox" id="selectAll" class="form-checkbox h-4 w-4 text-primary-600 rounded border-gray-300">
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Gönderen</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Araç Bilgisi</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">KM / Hasar</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">İletişim</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tarih</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">İşlemler</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($requests as $req)
                <tr class="hover:bg-gray-50 transition-colors {{ !$req->is_read ? 'bg-blue-50/50' : '' }}">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="checkbox" name="ids[]" class="row-checkbox form-checkbox h-4 w-4 text-primary-600 rounded border-gray-300" value="{{ $req->id }}">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap cursor-pointer" onclick="window.location.href='{{ route('admin.evaluation-requests.show', $req->id) }}'">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-primary-100 flex items-center justify-center flex-shrink-0">
                                <span class="text-sm font-bold text-primary-700">{{ strtoupper(mb_substr($req->name, 0, 1)) }}</span>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-900">{{ $req->name }}</div>
                                <div class="text-xs text-gray-400">{{ $req->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 cursor-pointer" onclick="window.location.href='{{ route('admin.evaluation-requests.show', $req->id) }}'">
                        <div class="text-sm font-semibold text-gray-900">{{ $req->brand }} {{ $req->model }}</div>
                        <div class="text-xs text-gray-400">{{ $req->year }} • {{ $req->fuel_type }} • {{ $req->transmission }}</div>
                    </td>
                    <td class="px-6 py-4 cursor-pointer" onclick="window.location.href='{{ route('admin.evaluation-requests.show', $req->id) }}'">
                        <div class="text-sm font-semibold text-gray-900">{{ $req->mileage ? number_format($req->mileage, 0, ',', '.') . ' KM' : '-' }}</div>
                        <div class="text-xs mt-0.5">
                            @if($req->condition === 'Hasarsız')
                                <span class="text-green-600 font-medium">{{ $req->condition }}</span>
                            @else
                                <span class="text-red-500 font-medium">{{ $req->condition ?? '-' }}</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm space-y-1">
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $req->phone) }}" class="text-primary-600 hover:text-primary-700 flex items-center gap-1">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                {{ $req->phone }}
                            </a>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        {{ $req->created_at->format('d.m.Y') }}
                        <div class="text-xs text-gray-400">{{ $req->created_at->format('H:i') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <div class="flex items-center justify-end gap-1.5">
                            @if(!$req->is_read)
                            <form action="{{ route('admin.evaluation-requests.read', $req->id) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="inline-flex items-center p-1.5 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition-colors" title="Okundu İşaretle">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </button>
                            </form>
                            @endif
                            <a href="{{ route('admin.evaluation-requests.pdf', $req->id) }}" class="inline-flex items-center p-1.5 bg-purple-50 text-purple-600 rounded-lg hover:bg-purple-100 transition-colors" title="PDF İndir">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </a>
                            <a href="{{ route('admin.evaluation-requests.show', $req->id) }}" class="inline-flex items-center p-1.5 bg-gray-50 text-gray-500 rounded-lg hover:bg-gray-100 transition-colors" title="Görüntüle">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            <form action="{{ route('admin.evaluation-requests.destroy', $req->id) }}" method="POST" class="inline-block"
                                  onsubmit="return confirmDelete(this, '{{ addslashes($req->brand . ' ' . $req->model) }} talebini')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center p-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors" title="Sil">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Bulk Actions -->
        <form id="bulk-action-form" method="POST" action="{{ route('admin.evaluation-requests.bulk-action') }}" class="hidden fixed bottom-8 left-1/2 -translate-x-1/2 bg-white/90 backdrop-blur px-8 py-4 rounded-2xl shadow-2xl border border-primary-100 items-center gap-6 z-50">
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
        @if($requests->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50/50 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-sm text-gray-500">
                <strong>{{ $requests->firstItem() }}–{{ $requests->lastItem() }}</strong> arası gösteriliyor
                (toplam <strong>{{ $requests->total() }}</strong> talep)
            </p>
            {{ $requests->links() }}
        </div>
        @endif
        @else
        <div class="p-12 text-center">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                @if(request()->hasAny(['search', 'status', 'date_from', 'date_to']))
                    Arama sonucu bulunamadı
                @else
                    Henüz değerleme isteği bulunmuyor
                @endif
            </h3>
            <p class="text-gray-500">
                @if(request()->hasAny(['search', 'status', 'date_from', 'date_to']))
                    Farklı bir filtre deneyin veya <a href="{{ route('admin.evaluation-requests.index') }}" class="text-primary-600 hover:underline">tüm talepleri</a> görüntüleyin.
                @else
                    Web sitesinden form dolduran kullanıcılar burada görünecek.
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
        html: `<p class="text-gray-600 mb-3">Toplam <strong class="text-red-600">${totalCount} değerleme talebi</strong> kalıcı olarak silinecek.</p>
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
                html: 'Tüm talepler siliniyor, lütfen bekleyin.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => Swal.showLoading()
            });
            document.getElementById('delete-all-form').submit();
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const checkboxes = document.querySelectorAll('.row-checkbox');
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

    document.getElementById('selectAll')?.addEventListener('change', e => {
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
            text: 'Seçili talepler kalıcı olarak silinecek.',
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
