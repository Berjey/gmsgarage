@extends('admin.layouts.app')

@section('title', 'Sitemap Yönetimi - Admin Panel')
@section('page-title', 'Sitemap Yönetimi')
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600">Dashboard</a>
    <span>/</span>
    <span>Sitemap</span>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                        </div>
                        Sitemap Yönetimi
                    </h2>
                    <p class="text-sm text-gray-600 mt-2">Toplam <span class="font-bold text-primary-600">{{ $stats['total'] }}</span> URL indekslenmiş</p>
                </div>
                <form action="{{ route('admin.sitemap.generate') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-semibold transition-colors shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Sitemap Oluştur
                    </button>
                </form>
            </div>
        </div>

        @if(session('success'))
        <div class="px-6 py-3 bg-green-50 border-b border-green-100 text-green-700 text-sm font-medium flex items-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            {{ session('success') }}
        </div>
        @endif
    </div>

    <!-- İstatistik Kartları -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="bg-white rounded-xl p-6 border-2 border-primary-100 shadow-sm group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Toplam URL</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                </div>
                <div class="w-12 h-12 bg-primary-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-6 border-2 border-gray-100 shadow-sm hover:border-blue-300 transition-all group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Araçlar</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $stats['vehicles'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-6 border-2 border-gray-100 shadow-sm hover:border-green-300 transition-all group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Blog Yazıları</p>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['blogPosts'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-6 border-2 border-gray-100 shadow-sm hover:border-purple-300 transition-all group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Kategoriler</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $stats['blogCategories'] }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-6 border-2 border-gray-100 shadow-sm hover:border-orange-300 transition-all group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Statik Sayfalar</p>
                    <p class="text-2xl font-bold text-orange-600">{{ $stats['staticPages'] }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Durum Bilgisi -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-900">Sitemap Durumu</h2>
        </div>
        <div class="p-6">

        <div class="space-y-1">
            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                <span class="text-gray-600">Dosya Durumu</span>
                @if($fileExists)
                    <span class="flex items-center text-green-600">
                        <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Mevcut
                    </span>
                @else
                    <span class="flex items-center text-red-600">
                        <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        Oluşturulmamış
                    </span>
                @endif
            </div>

            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                <span class="text-gray-600">Son Güncelleme</span>
                <span class="text-gray-900 font-medium">
                    @if($lastGenerated)
                        {{ \Carbon\Carbon::createFromTimestamp($lastGenerated)->format('d.m.Y H:i') }}
                    @else
                        -
                    @endif
                </span>
            </div>

            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                <span class="text-gray-600">Sitemap URL</span>
                <a href="{{ url('/sitemap.xml') }}" target="_blank" class="text-primary-600 hover:text-primary-700 flex items-center">
                    {{ url('/sitemap.xml') }}
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                </a>
            </div>

            <div class="flex items-center justify-between py-3">
                <span class="text-gray-600">Robots.txt</span>
                <span class="text-gray-500 text-sm">Sitemap: {{ url('/sitemap.xml') }}</span>
            </div>
        </div>
        </div>
    </div>

    <!-- URL Önizleme -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-bold text-gray-900">URL Önizleme</h2>
                <button type="button" id="loadPreview" class="px-4 py-2 text-sm font-semibold text-primary-600 bg-primary-50 rounded-xl hover:bg-primary-100 transition-colors">
                    Yükle
                </button>
            </div>
        </div>

        <div id="previewContainer" class="hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">URL</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tür</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Öncelik</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Güncelleme Sıklığı</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Son Değişiklik</th>
                        </tr>
                    </thead>
                    <tbody id="previewBody" class="bg-white divide-y divide-gray-200">
                    </tbody>
                </table>
            </div>
        </div>

        <div id="previewLoading" class="hidden p-8 text-center">
            <svg class="animate-spin h-8 w-8 mx-auto text-primary-600" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="mt-2 text-gray-500">Yükleniyor...</p>
        </div>

        <div id="previewEmpty" class="p-8 text-center text-gray-500">
            URL listesini görmek için "Yükle" butonuna tıklayın.
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('loadPreview').addEventListener('click', function() {
    const container = document.getElementById('previewContainer');
    const loading = document.getElementById('previewLoading');
    const empty = document.getElementById('previewEmpty');
    const body = document.getElementById('previewBody');

    empty.classList.add('hidden');
    loading.classList.remove('hidden');

    fetch('{{ route('admin.sitemap.preview') }}')
        .then(response => response.json())
        .then(data => {
            loading.classList.add('hidden');
            container.classList.remove('hidden');

            body.innerHTML = '';
            data.forEach(url => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50';
                row.innerHTML = `
                    <td class="px-6 py-4">
                        <a href="${url.loc}" target="_blank" class="text-primary-600 hover:text-primary-700 text-sm break-all">
                            ${url.loc}
                        </a>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${getTypeColor(url.type)}">
                            ${url.type}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">${url.priority}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">${url.changefreq}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">${url.lastmod || '-'}</td>
                `;
                body.appendChild(row);
            });
        })
        .catch(error => {
            loading.classList.add('hidden');
            empty.classList.remove('hidden');
            empty.textContent = 'Yüklenirken hata oluştu.';
        });
});

function getTypeColor(type) {
    const colors = {
        'Anasayfa': 'bg-primary-100 text-primary-800',
        'Hakkımızda': 'bg-gray-100 text-gray-800',
        'İletişim': 'bg-gray-100 text-gray-800',
        'Araçlar': 'bg-blue-100 text-blue-800',
        'Araç': 'bg-blue-100 text-blue-800',
        'Blog': 'bg-green-100 text-green-800',
        'Blog Yazısı': 'bg-green-100 text-green-800',
        'Blog Kategori': 'bg-purple-100 text-purple-800',
        'Araç Değerleme': 'bg-yellow-100 text-yellow-800',
        'Araç İsteği': 'bg-yellow-100 text-yellow-800',
        'KVKK': 'bg-red-100 text-red-800',
        'Gizlilik': 'bg-red-100 text-red-800',
        'Kullanım Şartları': 'bg-red-100 text-red-800',
    };
    return colors[type] || 'bg-gray-100 text-gray-800';
}
</script>
@endpush
@endsection
