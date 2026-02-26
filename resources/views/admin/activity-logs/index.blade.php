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

    <!-- Başlık -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                        <div class="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                        </div>
                        Aktivite Logları
                    </h2>
                    <p class="text-sm text-gray-600 mt-2">Toplam <span class="font-bold text-primary-600">{{ $activities->total() }}</span> aktivite kaydı</p>
                </div>
                <button type="button" onclick="clearAllLogs()" class="px-5 py-2.5 bg-red-50 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition-all flex items-center gap-2 font-semibold border border-red-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Tüm Logları Temizle
                </button>
            </div>
        </div>
    </div>

    <!-- Filtreler -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm" style="overflow:visible;">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <h3 class="text-sm font-semibold text-gray-700">Filtrele</h3>
        </div>
        <div class="p-6" style="overflow:visible;">
            <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="flex flex-wrap gap-3 items-end" style="overflow:visible;">
                
                <!-- Kullanıcı -->
                <div class="adm-dd" data-adm-dd style="width:220px; flex-shrink:0; position:relative; z-index:100;">
                    <label class="block text-xs font-medium text-gray-500 mb-1.5">Kullanıcı</label>
                    <input type="hidden" name="user_id" value="{{ request('user_id') }}">
                    <button type="button" class="adm-dd-btn" data-adm-trigger>
                        <span data-adm-label>
                            @if(request('user_id'))
                                @php $selectedUser = $users->firstWhere('id', request('user_id')); @endphp
                                {{ $selectedUser ? $selectedUser->name : 'Tüm Kullanıcılar' }}
                            @else
                                Tüm Kullanıcılar
                            @endif
                        </span>
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
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

                <!-- Aksiyon -->
                <div class="adm-dd" data-adm-dd style="width:200px; flex-shrink:0; position:relative; z-index:90;">
                    <label class="block text-xs font-medium text-gray-500 mb-1.5">Aksiyon</label>
                    <input type="hidden" name="action" value="{{ request('action') }}">
                    <button type="button" class="adm-dd-btn" data-adm-trigger>
                        <span data-adm-label>
                            @if(request('action'))
                                {{ $actions[request('action')] ?? 'Tüm Aksiyonlar' }}
                            @else
                                Tüm Aksiyonlar
                            @endif
                        </span>
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <ul class="adm-dd-list" data-adm-list>
                        <li data-value="" class="{{ !request('action') ? 'selected' : '' }}">Tüm Aksiyonlar</li>
                        @foreach($actions as $actionKey => $actionLabel)
                            <li data-value="{{ $actionKey }}" class="{{ request('action') == $actionKey ? 'selected' : '' }}">
                                {{ $actionLabel }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Tarih Başlangıç -->
                <div style="width:170px; flex-shrink:0;">
                    <label class="block text-xs font-medium text-gray-500 mb-1.5">Başlangıç</label>
                    <input type="date" 
                           name="date_from" 
                           value="{{ request('date_from') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 text-sm">
                </div>

                <!-- Tarih Bitiş -->
                <div style="width:170px; flex-shrink:0;">
                    <label class="block text-xs font-medium text-gray-500 mb-1.5">Bitiş</label>
                    <input type="date" 
                           name="date_to" 
                           value="{{ request('date_to') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 text-sm">
                </div>

                <!-- Butonlar -->
                <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                    Filtrele
                </button>
                @if(request('user_id') || request('action') || request('date_from') || request('date_to'))
                    <a href="{{ route('admin.activity-logs.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                        Temizle
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Aktivite Listesi -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        @if($activities->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Kullanıcı</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Aksiyon</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Açıklama</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">IP Adresi</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Tarih/Saat</th>
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
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50/50 flex items-center justify-between">
                <p class="text-sm text-gray-500">
                    {{ $activities->firstItem() }}-{{ $activities->lastItem() }} arası gösteriliyor
                    (toplam {{ $activities->total() }} kayıt)
                </p>
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
