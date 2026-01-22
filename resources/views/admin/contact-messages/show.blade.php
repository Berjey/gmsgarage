@extends('admin.layouts.app')

@section('title', 'Mesaj Detayı - Admin Panel')
@section('page-title', 'Mesaj Detayı')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Breadcrumb & Navigation -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
        <nav class="flex items-center space-x-2 text-sm text-gray-500">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600 transition-colors flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Panel
            </a>
            <span>/</span>
            <a href="{{ route('admin.contact-messages.index') }}" class="hover:text-primary-600 transition-colors">İletişim Mesajları</a>
            <span>/</span>
            <span class="text-gray-900 font-medium">Mesaj Detayı</span>
        </nav>

        <div class="flex items-center gap-2">
            @if(isset($previous))
            <a href="{{ route('admin.contact-messages.show', $previous->id) }}" 
               class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:text-primary-600 transition-all shadow-sm">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Önceki
            </a>
            @endif
            @if(isset($next))
            <a href="{{ route('admin.contact-messages.show', $next->id) }}" 
               class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:text-primary-600 transition-all shadow-sm">
                Sonraki
                <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-50 flex items-center justify-between bg-gray-50/30">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-primary-50 text-primary-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <h2 class="text-lg font-bold text-gray-900">Mesaj İçeriği</h2>
                    </div>
                    @include('admin.components.message-badge', ['isRead' => $message->is_read])
                </div>
                
                <div class="p-8 space-y-8">
                    <!-- Subject -->
                    <div class="relative pl-6 border-l-2 border-primary-500">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">KONU</label>
                        <h3 class="text-xl font-bold text-gray-900">{{ $message->subject ?? 'Konu Belirtilmemiş' }}</h3>
                    </div>

                    <!-- Message Body -->
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">MESAJ</label>
                        <div class="bg-gray-50/50 rounded-2xl p-6 border border-gray-100 text-gray-700 leading-relaxed text-lg italic relative">
                            <svg class="absolute top-4 left-4 w-8 h-8 text-gray-100 -z-10" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.899 14.899 16.017 16.017 16.017L19.017 16.017C19.569 16.017 20.017 15.569 20.017 15.017L20.017 13.017C20.017 12.465 19.569 12.017 19.017 12.017L14.017 12.017C12.906 12.017 12.017 11.128 12.017 10.017L12.017 6.017C12.017 4.906 12.906 4.017 14.017 4.017L18.017 4.017C19.128 4.017 20.017 4.906 20.017 6.017L20.017 12.017C20.017 13.128 19.128 14.017 18.017 14.017L16.017 14.017C14.906 14.017 14.017 14.906 14.017 16.017L14.017 19.017C14.017 20.128 14.906 21.017 16.017 21.017L14.017 21ZM4.017 21L4.017 18C4.017 16.899 4.899 16.017 6.017 16.017L9.017 16.017C9.569 16.017 10.017 15.569 10.017 15.017L10.017 13.017C10.017 12.465 9.569 12.017 9.017 12.017L4.017 12.017C2.906 12.017 2.017 11.128 2.017 10.017L2.017 6.017C2.017 4.906 2.906 4.017 4.017 4.017L8.017 4.017C9.128 4.017 10.017 4.906 10.017 6.017L10.017 12.017C10.017 13.128 9.128 14.017 8.017 14.017L6.017 14.017C4.906 14.017 4.017 14.906 4.017 16.017L4.017 19.017C4.017 20.128 4.906 21.017 6.017 21.017L4.017 21Z"></path></svg>
                            {{ $message->message }}
                        </div>
                    </div>

                    <!-- Meta Data -->
                    <div class="grid grid-cols-2 gap-4 pt-6 border-t border-gray-50">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">GÖNDERİM TARİHİ</label>
                            <p class="text-sm text-gray-900 font-medium">{{ $message->created_at->format('d.m.Y H:i') }}</p>
                        </div>
                        @if($message->read_at)
                        <div class="text-right">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">OKUNMA TARİHİ</label>
                            <p class="text-sm text-gray-900 font-medium">{{ \Carbon\Carbon::parse($message->read_at)->format('d.m.Y H:i') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="space-y-6">
            <!-- Action Card -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-50 bg-gray-50/30">
                    <h2 class="text-lg font-bold text-gray-900">Hızlı İşlemler</h2>
                </div>
                <div class="p-6 space-y-3">
                    @if($message->is_read)
                        <form method="POST" action="{{ route('admin.contact-messages.unread', $message->id) }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-white text-gray-700 font-bold rounded-xl border border-gray-200 hover:bg-gray-50 hover:text-primary-600 transition-all shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"></path></svg>
                                Okunmamış İşaretle
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin.contact-messages.read', $message->id) }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 transition-all shadow-lg shadow-primary-500/25">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Okundu İşaretle
                            </button>
                        </form>
                    @endif

                    <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}" 
                       class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-white text-gray-700 font-bold rounded-xl border border-gray-200 hover:bg-gray-50 hover:text-blue-600 transition-all shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        E-posta ile Yanıtla
                    </a>

                    <a href="{{ \App\Models\Setting::get('contact_mail_hostinger_link', 'https://mail.hostinger.com/v2/mailboxes/INBOX') }}" 
                       target="_blank"
                       class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-white text-gray-700 font-bold rounded-xl border border-gray-200 hover:bg-gray-50 hover:text-indigo-600 transition-all shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                        Mail Paneline Git
                    </a>

                    <button type="button"
                            onclick="openDeleteModal({{ $message->id }}, '{{ route('admin.contact-messages.destroy', $message->id) }}')"
                            class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-50 text-red-600 font-bold rounded-xl border border-red-100 hover:bg-red-600 hover:text-white transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Mesajı Sil
                    </button>
                </div>
            </div>

            <!-- Contact Card -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-50 bg-gray-50/30">
                    <h2 class="text-lg font-bold text-gray-900">Gönderen Bilgileri</h2>
                </div>
                <div class="p-6 space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-primary-50 text-primary-600 rounded-full flex items-center justify-center text-xl font-bold">
                            {{ strtoupper(substr($message->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">AD SOYAD</p>
                            <p class="text-base font-bold text-gray-900">{{ $message->name }}</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="mt-1 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div class="flex-1 overflow-hidden">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">E-POSTA</p>
                                <a href="mailto:{{ $message->email }}" class="text-sm font-bold text-primary-600 hover:underline break-all">{{ $message->email }}</a>
                            </div>
                        </div>

                        @if($message->phone)
                        <div class="flex items-start gap-3">
                            <div class="mt-1 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">TELEFON</p>
                                <a href="tel:{{ $message->phone }}" class="text-sm font-bold text-primary-600 hover:underline">{{ $message->phone }}</a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
@include('admin.components.confirm-modal', [
    'id' => 'delete-modal',
    'title' => 'Mesajı Sil',
    'message' => 'Bu mesajı silmek istediğinize emin misiniz? Bu işlem geri alınamaz.',
    'confirmText' => 'Sil',
    'cancelText' => 'Vazgeç'
])

@push('scripts')
<script>
    function openDeleteModal(id, url) {
        const form = document.getElementById('confirm-form-delete-modal');
        form.action = url;
        document.getElementById('delete-modal').classList.remove('hidden');
    }
</script>
@endpush
@endsection
