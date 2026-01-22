@extends('admin.layouts.app')

@section('title', 'Medya Kütüphanesi - Admin Panel')
@section('page-title', 'Medya Kütüphanesi')
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600">Dashboard</a>
    <span>/</span>
    <span>Medya</span>
@endsection

@section('content')
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <!-- Header -->
    <div class="p-6 border-b border-gray-200 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Medya Kütüphanesi</h2>
            <p class="text-sm text-gray-600 mt-1">Toplam {{ count($files) }} dosya</p>
        </div>
        <button onclick="document.getElementById('file-upload').click()" 
                class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-semibold transition-colors flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
            </svg>
            Dosya Yükle
        </button>
        <input type="file" id="file-upload" class="hidden" multiple onchange="uploadFiles(this.files)">
    </div>

    <!-- Media Grid -->
    <div class="p-6">
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4" id="media-grid">
            @forelse($files as $file)
            <div class="group relative bg-gray-50 rounded-xl border border-gray-200 overflow-hidden hover:shadow-md transition-all">
                <div class="aspect-square">
                    @if(Str::startsWith($file['mime'], 'image/'))
                        <img src="{{ $file['url'] }}" alt="{{ $file['name'] }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-100">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                </div>
                
                <!-- Overlay -->
                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center gap-2 p-2 text-center">
                    <p class="text-white text-xs font-medium truncate w-full px-2">{{ $file['name'] }}</p>
                    <div class="flex gap-2">
                        <button onclick="copyToClipboard('{{ $file['url'] }}')" class="p-1.5 bg-white/20 hover:bg-white/40 text-white rounded-lg transition-colors" title="Linki Kopyala">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
                            </svg>
                        </button>
                        <button onclick="deleteFile('{{ $file['path'] }}')" class="p-1.5 bg-red-500/20 hover:bg-red-500/40 text-white rounded-lg transition-colors" title="Sil">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-20 text-center text-gray-500 italic">
                Kütüphane henüz boş. Dosya yükleyerek başlayın.
            </div>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert('Dosya yolu kopyalandı!');
        });
    }

    function deleteFile(path) {
        if (confirm('Bu dosyayı silmek istediğinize emin misiniz?')) {
            fetch('{{ route("admin.media.destroy") }}', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ path: path })
            }).then(res => res.json())
            .then(data => {
                if (data.success) location.reload();
                else alert(data.message || 'Dosya silinemedi.');
            });
        }
    }

    function uploadFiles(files) {
        const formData = new FormData();
        for (let i = 0; i < files.length; i++) {
            formData.append('file', files[i]);
            
            fetch('{{ route("admin.media.upload") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            }).then(res => res.json())
            .then(data => {
                if (i === files.length - 1) location.reload();
            });
        }
    }
</script>
@endpush
@endsection
