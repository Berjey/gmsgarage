@extends('admin.layouts.app')

@section('title', 'Kullanıcı Aktiviteleri - Admin Panel')
@section('page-title', 'Kullanıcı Aktivite Takibi')
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600">Dashboard</a>
    <span>/</span>
    <span>Aktivite Logları</span>
@endsection

@section('content')
<div class="space-y-6">
    
    <!-- Filtreler -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Kullanıcı Filtresi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kullanıcı</label>
                    <div class="adm-dd" data-adm-dd>
                        <input type="hidden" name="user_id" value="{{ request('user_id') }}" id="user-filter-input">
                        <button type="button" class="adm-dd-btn" data-adm-trigger>
                            <span data-adm-label style="{{ !request('user_id') ? 'color:#9ca3af;' : '' }}">
                                @if(request('user_id'))
                                    {{ $users->firstWhere('id', request('user_id'))->name ?? 'Tüm Kullanıcılar' }}
                                @else
                                    Tüm Kullanıcılar
                                @endif
                            </span>
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <ul class="adm-dd-list" data-adm-list>
                            <li data-value="" class="{{ !request('user_id') ? 'selected' : '' }}">Tüm Kullanıcılar</li>
                            @foreach($users as $user)
                                <li data-value="{{ $user->id }}" class="{{ request('user_id') == $user->id ? 'selected' : '' }}">
                                    {{ $user->name }} ({{ $user->role_name }})
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Aksiyon Filtresi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Aksiyon</label>
                    <div class="adm-dd" data-adm-dd>
                        <input type="hidden" name="action" value="{{ request('action') }}" id="action-filter-input">
                        <button type="button" class="adm-dd-btn" data-adm-trigger>
                            <span data-adm-label style="{{ !request('action') ? 'color:#9ca3af;' : '' }}">
                                @if(request('action') == 'login') 🔐 Giriş
                                @elseif(request('action') == 'created') ➕ Oluşturma
                                @elseif(request('action') == 'updated') ✏️ Güncelleme
                                @elseif(request('action') == 'deleted') 🗑️ Silme
                                @elseif(request('action') == 'viewed') 👁️ Görüntüleme
                                @else Tüm Aksiyonlar
                                @endif
                            </span>
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <ul class="adm-dd-list" data-adm-list>
                            <li data-value="" class="{{ !request('action') ? 'selected' : '' }}">Tüm Aksiyonlar</li>
                            <li data-value="login" class="{{ request('action') == 'login' ? 'selected' : '' }}">🔐 Giriş</li>
                            <li data-value="created" class="{{ request('action') == 'created' ? 'selected' : '' }}">➕ Oluşturma</li>
                            <li data-value="updated" class="{{ request('action') == 'updated' ? 'selected' : '' }}">✏️ Güncelleme</li>
                            <li data-value="deleted" class="{{ request('action') == 'deleted' ? 'selected' : '' }}">🗑️ Silme</li>
                            <li data-value="viewed" class="{{ request('action') == 'viewed' ? 'selected' : '' }}">👁️ Görüntüleme</li>
                        </ul>
                    </div>
                </div>

                <!-- Başlangıç Tarihi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Başlangıç</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                </div>

                <!-- Bitiş Tarihi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bitiş</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                </div>
            </div>

            <div class="flex justify-between items-center">
                <div class="flex space-x-3">
                    <button type="button" onclick="clearAllLogs()" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Tüm Logları Temizle
                    </button>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.activity-logs.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Filtreyi Temizle
                    </a>
                    <button type="submit" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors">
                        Filtrele
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Aktivite Listesi -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Aktivite Geçmişi</h2>
                    <p class="text-sm text-gray-500 mt-1">Toplam {{ $activities->total() }} kayıt bulundu</p>
                </div>
            </div>
        </div>

        @if($activities->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kullanıcı</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksiyon</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Açıklama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP Adresi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarih/Saat</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($activities as $activity)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-10 h-10 bg-{{ $activity->user->role_badge_color }}-100 rounded-full flex items-center justify-center">
                                            <span class="text-{{ $activity->user->role_badge_color }}-600 font-bold text-sm">
                                                {{ substr($activity->user->name, 0, 1) }}
                                            </span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $activity->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $activity->user->role_name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-{{ $activity->color }}-100 text-{{ $activity->color }}-700">
                                        <span class="mr-1">{{ $activity->icon }}</span>
                                        {{ ucfirst($activity->action) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $activity->description }}</div>
                                    @if($activity->model_type)
                                        <div class="text-xs text-gray-500 mt-1">
                                            {{ class_basename($activity->model_type) }} #{{ $activity->model_id }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $activity->ip_address }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $activity->created_at->format('d.m.Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $activity->created_at->format('H:i:s') }}</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $activities->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Aktivite bulunamadı</h3>
                <p class="mt-1 text-sm text-gray-500">Seçtiğiniz filtrelere uygun aktivite kaydı bulunmuyor.</p>
            </div>
        @endif
    </div>
</div>

<!-- Hidden Form for Delete Actions -->
<form id="clear-all-form" method="POST" action="{{ route('admin.activity-logs.clear-all') }}" style="display: none;">
    @csrf
</form>
@endsection

@push('scripts')
<script>
function clearAllLogs() {
    Swal.fire({
        title: 'TÜM Logları Temizle?',
        html: '<strong class="text-red-600">⚠️ DİKKAT!</strong><br>Bu işlem GERİ ALINAMAZ!<br>Tüm aktivite geçmişi silinecek.',
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Evet, Hepsini Sil!',
        cancelButtonText: 'İptal',
        customClass: {
            popup: 'rounded-xl',
            confirmButton: 'rounded-lg px-6 py-2.5 font-semibold',
            cancelButton: 'rounded-lg px-6 py-2.5 font-semibold'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('clear-all-form').submit();
        }
    });
}
</script>
@endpush
