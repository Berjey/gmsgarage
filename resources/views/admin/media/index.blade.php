@extends('admin.layouts.app')

@section('content')
<div class="bg-white dark:bg-[#252525] rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm">
    <div class="p-6 border-b border-gray-200 dark:border-gray-800">
        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Medya Kütüphanesi</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Yüklenen dosyaları görüntüleyin ve yönetin</p>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @forelse($files as $file)
            <div class="relative group">
                <div class="aspect-square bg-gray-100 dark:bg-[#1e1e1e] rounded-lg overflow-hidden">
                    @if(str_starts_with($file['mime'], 'image/'))
                        <img src="{{ $file['url'] }}" alt="{{ $file['name'] }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-opacity rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100">
                    <button onclick="copyUrl('{{ $file['url'] }}')" class="text-white mx-1 p-2 bg-primary-600 rounded hover:bg-primary-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </button>
                    <button onclick="deleteFile('{{ $file['path'] }}')" class="text-white mx-1 p-2 bg-red-600 rounded hover:bg-red-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
                <p class="mt-2 text-xs text-gray-600 dark:text-gray-400 truncate">{{ $file['name'] }}</p>
            </div>
            @empty
            <div class="col-span-full text-center py-12 text-gray-500 dark:text-gray-400">
                Henüz dosya yüklenmemiş
            </div>
            @endforelse
        </div>
    </div>
</div>

<script>
function copyUrl(url) {
    navigator.clipboard.writeText(url).then(() => {
        alert('URL kopyalandı!');
    });
}

function deleteFile(path) {
    if (!confirm('Bu dosyayı silmek istediğinize emin misiniz?')) return;
    
    fetch('{{ route("admin.media.destroy") }}', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ path: path })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Dosya silinirken bir hata oluştu.');
        }
    });
}
</script>
@endsection
