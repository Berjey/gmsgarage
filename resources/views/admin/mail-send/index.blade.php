@extends('admin.layouts.app')

@section('title', 'E-posta Gönder - Admin Panel')
@section('page-title', 'Kurumsal E-posta Gönderim Paneli')

@push('styles')
<style>
    .preview-container {
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        overflow: hidden;
        background: #f9fafb;
    }
    .preview-iframe {
        width: 100%;
        border: none;
        min-height: 500px;
    }
</style>
@endpush

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form id="mailForm" action="{{ route('admin.mail-send.send') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Alıcı E-posta -->
                <div>
                    <label for="recipient_email" class="block text-sm font-semibold text-gray-700 mb-2">
                        Alıcı E-posta *
                    </label>
                    <input type="email" 
                           id="recipient_email" 
                           name="recipient_email" 
                           value="{{ old('recipient_email') }}"
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                </div>

                <!-- Müşteri Adı -->
                <div>
                    <label for="customer_name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Müşteri Adı *
                    </label>
                    <input type="text" 
                           id="customer_name" 
                           name="customer_name" 
                           value="{{ old('customer_name') }}"
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                </div>

                <!-- Konu -->
                <div class="md:col-span-2">
                    <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">
                        Konu *
                    </label>
                    <input type="text" 
                           id="subject" 
                           name="subject" 
                           value="{{ old('subject') }}"
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                </div>

                <!-- İstek Tipi -->
                <div>
                    <label for="request_type" class="block text-sm font-semibold text-gray-700 mb-2">
                        İstek Tipi
                    </label>
                    <select id="request_type" 
                            name="request_type"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        <option value="">Seçiniz (Opsiyonel)</option>
                        <option value="degerleme_alindi" {{ old('request_type') == 'degerleme_alindi' ? 'selected' : '' }}>Değerleme Alındı</option>
                        <option value="iletisim_alindi" {{ old('request_type') == 'iletisim_alindi' ? 'selected' : '' }}>İletişim Alındı</option>
                    </select>
                </div>

                <!-- Referans ID -->
                <div>
                    <label for="reference_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Referans ID (Opsiyonel)
                    </label>
                    <input type="text" 
                           id="reference_id" 
                           name="reference_id" 
                           value="{{ old('reference_id') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                </div>
            </div>

            <!-- Mesaj Metni -->
            <div class="mb-6">
                <label for="message_text" class="block text-sm font-semibold text-gray-700 mb-2">
                    Mesaj Metni *
                </label>
                <textarea id="message_text" 
                          name="message_text" 
                          rows="8"
                          required
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                          placeholder="Müşteriye göndermek istediğiniz mesajı buraya yazın...">{{ old('message_text') }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Satır sonları otomatik olarak HTML formatına çevrilecektir.</p>
            </div>

            <!-- Önizleme Butonu -->
            <div class="mb-6">
                <button type="button" 
                        id="previewBtn"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors">
                    Önizleme Göster
                </button>
            </div>

            <!-- Önizleme Alanı -->
            <div id="previewContainer" class="hidden mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">E-posta Önizleme</h3>
                <div class="preview-container">
                    <iframe id="previewFrame" class="preview-iframe" srcdoc=""></iframe>
                </div>
            </div>

            <!-- Gönder Butonu -->
            <div class="flex gap-4">
                <button type="submit" 
                        class="px-8 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-colors shadow-sm">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    E-postayı Gönder
                </button>
                <a href="{{ route('admin.mail-send.logs') }}" 
                   class="px-8 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition-colors shadow-sm">
                    Gönderim Kayıtları
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const previewBtn = document.getElementById('previewBtn');
    const previewContainer = document.getElementById('previewContainer');
    const previewFrame = document.getElementById('previewFrame');
    const form = document.getElementById('mailForm');

    previewBtn.addEventListener('click', function() {
        const formData = new FormData(form);
        
        fetch('{{ route("admin.mail-send.preview") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                previewFrame.srcdoc = data.html;
                previewContainer.classList.remove('hidden');
            } else {
                alert('Önizleme oluşturulamadı: ' + (data.errors ? Object.values(data.errors).flat().join(', ') : 'Bilinmeyen hata'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Önizleme oluşturulurken bir hata oluştu.');
        });
    });
});
</script>
@endpush
