@extends('admin.layouts.app')

@section('title', 'İletişim Sayfası Ayarları - Admin Panel')
@section('page-title', 'İletişim Sayfası Ayarları')
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600 dark:hover:text-primary-400">Dashboard</a>
    <span>/</span>
    <a href="{{ route('admin.settings.index') }}" class="hover:text-primary-600 dark:hover:text-primary-400">Ayarlar</a>
    <span>/</span>
    <span>İletişim Ayarları</span>
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">İletişim Sayfası Ayarları</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">İletişim sayfası içeriğini ve mail ayarlarını yönetin</p>
        </div>
    </div>

    <form action="{{ route('admin.contact-settings.update') }}" method="POST" class="bg-white dark:bg-[#252525] rounded-lg shadow-sm border border-gray-200 dark:border-gray-800 p-6">
        @csrf
        @method('PUT')

        <!-- Mail Ayarları -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4 pb-2 border-b border-gray-200 dark:border-gray-800">Mail Ayarları</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Mail Alıcı Adresi <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           name="contact_mail_recipient" 
                           value="{{ old('contact_mail_recipient', $settings['contact_mail_recipient']) }}"
                           required
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-[#1e1e1e] text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                           placeholder="info@gmsgarage.com">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Form mesajları bu adrese gönderilecek</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Hostinger Mail Paneli Linki <span class="text-red-500">*</span>
                    </label>
                    <input type="url" 
                           name="contact_mail_hostinger_link" 
                           value="{{ old('contact_mail_hostinger_link', $settings['contact_mail_hostinger_link']) }}"
                           required
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-[#1e1e1e] text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                           placeholder="https://mail.hostinger.com/v2/mailboxes/INBOX">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Panel'de mail paneline yönlendirme için kullanılacak</p>
                </div>
            </div>
        </div>

        <!-- İletişim Bilgileri -->
        <div class="mb-8 border-t border-gray-200 dark:border-gray-800 pt-8">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4 pb-2 border-b border-gray-200 dark:border-gray-800">İletişim Bilgileri</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        E-posta Adresi <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           name="contact_email" 
                           value="{{ old('contact_email', $settings['contact_email']) }}"
                           required
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-[#1e1e1e] text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                           placeholder="info@gmsgarage.com">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">İletişim sayfasında gösterilecek e-posta</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Telefon Numarası
                    </label>
                    <input type="text" 
                           name="contact_phone" 
                           value="{{ old('contact_phone', $settings['contact_phone']) }}"
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-[#1e1e1e] text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                           placeholder="0555 123 45 67">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        WhatsApp Numarası
                    </label>
                    <input type="text" 
                           name="contact_whatsapp" 
                           value="{{ old('contact_whatsapp', $settings['contact_whatsapp']) }}"
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-[#1e1e1e] text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                           placeholder="0555 123 45 67">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Adres
                    </label>
                    <input type="text" 
                           name="contact_address" 
                           value="{{ old('contact_address', $settings['contact_address']) }}"
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-[#1e1e1e] text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                           placeholder="Görsel Mah. Kağıthane Cad. No: 26 /1A KAĞITHANE/İSTANBUL">
                </div>
            </div>
        </div>

        <!-- Form Ayarları -->
        <div class="mb-8 border-t border-gray-200 dark:border-gray-800 pt-8">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4 pb-2 border-b border-gray-200 dark:border-gray-800">Form Ayarları</h2>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Form Açıklama Metni
                </label>
                <textarea name="contact_form_description" 
                          rows="3"
                          class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-[#1e1e1e] text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                          placeholder="Sorularınız, önerileriniz veya destek talepleriniz için aşağıdaki formu doldurun...">{{ old('contact_form_description', $settings['contact_form_description']) }}</textarea>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Form başlığının altında gösterilecek açıklama metni</p>
            </div>
        </div>

        <!-- Google Maps -->
        <div class="mb-8 border-t border-gray-200 dark:border-gray-800 pt-8">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4 pb-2 border-b border-gray-200 dark:border-gray-800">Google Maps</h2>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Google Maps Embed Kodu
                </label>
                <textarea name="contact_google_maps_embed" 
                          rows="4"
                          class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-[#1e1e1e] text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent font-mono text-sm"
                          placeholder='<iframe src="https://www.google.com/maps/embed?pb=..." width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>'>{{ old('contact_google_maps_embed', $settings['contact_google_maps_embed']) }}</textarea>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Google Maps'ten alacağınız embed kodunu buraya yapıştırın. 
                    <a href="https://www.google.com/maps" target="_blank" class="text-primary-600 dark:text-primary-400 hover:underline">Google Maps'ten kod al</a>
                </p>
            </div>
        </div>

        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-800">
            <a href="{{ route('admin.settings.index') }}" class="px-6 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-lg font-medium transition-colors">
                İptal
            </a>
            <button type="submit" class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-medium transition-colors">
                Ayarları Kaydet
            </button>
        </div>
    </form>
</div>
@endsection
