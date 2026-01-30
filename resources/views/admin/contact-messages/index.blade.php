@extends('admin.layouts.app')

@section('title', 'İletişim Mesajları - Admin Panel')
@section('page-title', 'İletişim Mesajları')

@push('styles')
<style>
    /* Message preview line clamp */
    .message-preview {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Light Mode Uyumlu Dropdown */
    .hero-custom-dropdown-panel {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        z-index: 50;
        background: white;
        margin-top: 0.5rem;
        border: 1px solid #e5e7eb;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.04);
    }
    
    .hero-custom-dropdown-panel.open {
        display: block;
        animation: dropdownFade 0.2s ease-out;
    }
    
    @keyframes dropdownFade {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .hero-custom-dropdown-option {
        padding: 0.75rem 1rem;
        cursor: pointer;
        transition: all 0.2s;
        color: #374151;
        font-weight: 500;
    }

    .hero-custom-dropdown-option:hover {
        background-color: #f9fafb;
        color: #dc2626;
    }

    .hero-custom-dropdown-option.selected {
        background-color: #fef2f2;
        color: #dc2626;
        font-weight: 700;
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header Area -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">İletişim Mesajları</h1>
            <p class="mt-1 text-sm text-gray-500 font-medium tracking-wide uppercase">GELEN MESAJLARIN YÖNETİMİ</p>
        </div>
        <div class="flex items-center gap-3">
            <button type="button"
                    onclick="openDeleteAllModal()"
                    class="inline-flex items-center px-5 py-2.5 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-all shadow-lg shadow-red-500/25 group">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                Tümünü Sil
            </button>
            <a href="{{ \App\Models\Setting::get('contact_mail_hostinger_link', 'https://mail.hostinger.com/v2/mailboxes/INBOX') }}" 
               target="_blank"
               class="inline-flex items-center px-5 py-2.5 bg-white text-gray-700 font-bold rounded-xl border border-gray-200 hover:bg-gray-50 hover:text-primary-600 transition-all shadow-sm group">
                <svg class="w-5 h-5 mr-2 text-gray-400 group-hover:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                Mail Paneline Git
            </a>
        </div>
    </div>

    <!-- Toolbar & Filters -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-6 bg-gray-50/30 border-b border-gray-50">
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

                    <!-- Dropdowns - Light Mode Optimized -->
                    <div class="relative hero-custom-dropdown" data-dropdown="filter-status">
                        <button type="button" 
                                style="background-color: #ffffff !important;"
                                class="hero-custom-dropdown-trigger w-full flex items-center justify-between px-4 py-3 border border-gray-200 rounded-xl text-gray-800 font-semibold hover:bg-gray-50 hover:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all shadow-sm"
                                aria-expanded="false" aria-haspopup="listbox">
                            <span class="selected-text">{{ $filter === 'unread' ? 'Okunmamış' : ($filter === 'read' ? 'Okunmuş' : 'Tüm Mesajlar') }}</span>
                            <svg class="arrow w-5 h-5 text-gray-500 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div class="hero-custom-dropdown-panel rounded-xl" role="listbox">
                            <div class="hero-custom-dropdown-option {{ $filter === 'all' ? 'selected' : '' }}" data-value="all" role="option">Tüm Mesajlar</div>
                            <div class="hero-custom-dropdown-option {{ $filter === 'unread' ? 'selected' : '' }}" data-value="unread" role="option">Okunmamış</div>
                            <div class="hero-custom-dropdown-option {{ $filter === 'read' ? 'selected' : '' }}" data-value="read" role="option">Okunmuş</div>
                        </div>
                        <select name="filter" class="hero-custom-dropdown-native hidden">
                            <option value="all" {{ $filter === 'all' ? 'selected' : '' }}>Tümü</option>
                            <option value="unread" {{ $filter === 'unread' ? 'selected' : '' }}>Okunmamış</option>
                            <option value="read" {{ $filter === 'read' ? 'selected' : '' }}>Okunmuş</option>
                        </select>
                    </div>

                    <div class="relative hero-custom-dropdown" data-dropdown="sort-order">
                        <button type="button" 
                                style="background-color: #ffffff !important;"
                                class="hero-custom-dropdown-trigger w-full flex items-center justify-between px-4 py-3 border border-gray-200 rounded-xl text-gray-800 font-semibold hover:bg-gray-50 hover:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all shadow-sm"
                                aria-expanded="false" aria-haspopup="listbox">
                            <span class="selected-text">{{ request('sort') === 'oldest' ? 'Eskiden Yeniye' : 'Yeniden Eskiye' }}</span>
                            <svg class="arrow w-5 h-5 text-gray-500 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div class="hero-custom-dropdown-panel rounded-xl" role="listbox">
                            <div class="hero-custom-dropdown-option {{ request('sort') !== 'oldest' ? 'selected' : '' }}" data-value="newest" role="option">Yeniden Eskiye</div>
                            <div class="hero-custom-dropdown-option {{ request('sort') === 'oldest' ? 'selected' : '' }}" data-value="oldest" role="option">Eskiden Yeniye</div>
                        </div>
                        <select name="sort" class="hero-custom-dropdown-native hidden">
                            <option value="newest" {{ request('sort') !== 'oldest' ? 'selected' : '' }}>Yeniden Eskiye</option>
                            <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Eskiden Yeniye</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ route('admin.contact-messages.index') }}" 
                       class="px-6 py-2.5 bg-white text-gray-600 font-bold rounded-xl border border-gray-200 hover:bg-gray-50 transition-all shadow-sm">
                        Sıfırla
                    </a>
                    <button type="submit" 
                            class="px-8 py-2.5 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 transition-all shadow-lg shadow-primary-500/25">
                        Filtrele
                    </button>
                </div>
            </form>
        </div>

        <!-- Table Area -->
        <div class="overflow-x-auto">
            @if($messages->count() > 0)
                <table class="w-full">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">GÖNDEREN</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">KONU / ÖNİZLEME</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-widest">TARİH</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-widest">DURUM</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-widest">İŞLEMLER</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($messages as $message)
                        <tr class="group hover:bg-gray-50 transition-all cursor-pointer {{ !$message->is_read ? 'bg-primary-50/10' : '' }}"
                            onclick="window.location.href='{{ route('admin.contact-messages.show', $message->id) }}'">
                            <td class="px-6 py-5">
                                <div class="font-bold text-gray-900 group-hover:text-primary-600 transition-colors">{{ $message->name }}</div>
                                <div class="text-sm text-gray-500 font-medium">{{ $message->email }}</div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="font-bold text-gray-800 line-clamp-1 max-w-md">{{ $message->subject ?? 'Konu Yok' }}</div>
                                <div class="text-sm text-gray-400 font-medium line-clamp-1 max-w-md italic">{{ $message->message }}</div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <div class="text-sm font-semibold text-gray-700">{{ $message->created_at->format('d.m.Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $message->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-5 text-center" onclick="event.stopPropagation()">
                                @include('admin.components.message-badge', ['isRead' => $message->is_read])
                            </td>
                            <td class="px-6 py-5 text-right" onclick="event.stopPropagation()">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.contact-messages.show', $message->id) }}" 
                                       class="p-2.5 text-blue-600 bg-blue-50 rounded-xl hover:bg-blue-600 hover:text-white transition-all shadow-sm"
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
            @else
            <div class="text-center py-20 bg-gray-50/20">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Henüz Mesaj Yok</h3>
                <p class="text-gray-500 font-medium">İletişim formundan gelen mesajlar burada listelenecektir.</p>
            </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($messages->hasPages())
        <div class="px-6 py-5 bg-gray-50/30 border-t border-gray-50 flex items-center justify-between">
            <div class="text-sm font-bold text-gray-500 uppercase tracking-widest">
                {{ $messages->firstItem() }}-{{ $messages->lastItem() }} / {{ $messages->total() }} MESAJ
            </div>
            <div class="flex items-center gap-4 font-bold">
                <select onchange="window.location.href='{{ request()->fullUrlWithQuery(['per_page' => '__PER_PAGE__', 'page' => 1]) }}'.replace('__PER_PAGE__', this.value)"
                        class="bg-white border border-gray-200 rounded-xl px-3 py-1.5 focus:ring-primary-500/20 transition-all">
                    <option value="25" {{ request('per_page', 25) == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                </select>
                {{ $messages->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

@include('admin.components.confirm-modal', [
    'id' => 'delete-modal',
    'title' => 'Mesajı Sil',
    'message' => 'Bu mesajı silmek istediğinize emin misiniz? Bu işlem geri alınamaz.',
    'confirmText' => 'Sil',
    'cancelText' => 'Vazgeç'
])

@include('admin.components.confirm-modal', [
    'id' => 'delete-all-modal',
    'title' => 'Tüm Mesajları Sil',
    'message' => 'Tüm iletişim mesajlarını silmek istediğinize emin misiniz? Bu işlem geri alınamaz ve tüm mesajlar kalıcı olarak silinecektir.',
    'confirmText' => 'Tümünü Sil',
    'cancelText' => 'Vazgeç'
])

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // [PATCH #4.3] Idempotent Unified Dropdown Handler with Guardrails
        const initDropdowns = () => {
            document.querySelectorAll('.hero-custom-dropdown:not([data-initialized])').forEach(dropdown => {
                const trigger = dropdown.querySelector('.hero-custom-dropdown-trigger');
                const panel = dropdown.querySelector('.hero-custom-dropdown-panel');
                const select = dropdown.querySelector('.hero-custom-dropdown-native');

                trigger.addEventListener('click', e => {
                    e.stopPropagation();
                    const isOpen = panel.classList.contains('open');
                    
                    // Close other open dropdowns
                    document.querySelectorAll('.hero-custom-dropdown-panel.open').forEach(p => {
                        if (p !== panel) {
                            p.classList.remove('open');
                            p.closest('.hero-custom-dropdown').querySelector('.hero-custom-dropdown-trigger').setAttribute('aria-expanded', 'false');
                        }
                    });

                    // Toggle current
                    panel.classList.toggle('open');
                    trigger.setAttribute('aria-expanded', !isOpen);
                });

                dropdown.querySelectorAll('.hero-custom-dropdown-option').forEach(opt => {
                    opt.addEventListener('click', () => {
                        select.value = opt.dataset.value;
                        document.getElementById('filter-form').submit();
                    });
                });

                dropdown.setAttribute('data-initialized', '1');
            });
        };

        initDropdowns();

        // Single global outside click handler for all initialized dropdowns
        document.addEventListener('click', () => {
            document.querySelectorAll('.hero-custom-dropdown-panel.open').forEach(p => {
                p.classList.remove('open');
                p.closest('.hero-custom-dropdown').querySelector('.hero-custom-dropdown-trigger').setAttribute('aria-expanded', 'false');
            });
        });
    });

    function openDeleteModal(id, url) {
        document.getElementById('confirm-form-delete-modal').action = url;
        document.getElementById('delete-modal').classList.remove('hidden');
    }

    function openDeleteAllModal() {
        document.getElementById('confirm-form-delete-all-modal').action = '{{ route('admin.contact-messages.destroy-all') }}';
        document.getElementById('delete-all-modal').classList.remove('hidden');
    }
</script>
@endpush
@endsection
