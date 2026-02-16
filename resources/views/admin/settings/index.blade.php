@extends('admin.layouts.app')

@section('title', 'Site Ayarları')

@section('content')
<div x-data="{
    activeTab: 'general',
    footerLinks: {{ json_encode(json_decode($settings['footer_bottom_links'] ?? '[]', true)) }},
    showModal: false,
    currentSlug: '',
    modalTitle: '',
    editorInstance: null,
    
    addLink() {
        this.footerLinks.push({ label: '', url: '' });
    },
    
    removeLink(index) {
        Swal.fire({
            title: 'Emin misiniz?',
            text: 'Bu link silinecek!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#E32222',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Evet, Sil',
            cancelButtonText: 'İptal'
        }).then((result) => {
            if (result.isConfirmed) {
                this.footerLinks.splice(index, 1);
                Swal.fire('Silindi!', 'Link kaldırıldı.', 'success');
            }
        });
    },
    
    updateUrl(index) {
        let label = this.footerLinks[index].label;
        if (!label) return;
        let slug = label.toLowerCase()
            .replace(/ğ/g, 'g').replace(/ü/g, 'u').replace(/ş/g, 's')
            .replace(/ı/g, 'i').replace(/ö/g, 'o').replace(/ç/g, 'c')
            .replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
        this.footerLinks[index].url = slug;
    },
    
    openContentModal(index) {
        let link = this.footerLinks[index];
        if (!link.label || !link.url) {
            Swal.fire({
                icon: 'warning',
                title: 'Geçersiz Link',
                text: 'Lütfen önce başlığı girin ve URL oluşsun.'
            });
            return;
        }
        
        this.currentSlug = link.url;
        this.modalTitle = link.label;
        this.showModal = true;
        
        // Mevcut içeriği yükle
        fetch('/admin/api/pages/get-by-slug?slug=' + encodeURIComponent(this.currentSlug))
            .then(res => res.json())
            .then(data => {
                if (this.editorInstance && data.content) {
                    this.editorInstance.setData(data.content);
                }
            })
            .catch(() => {
                if (this.editorInstance) {
                    this.editorInstance.setData('');
                }
            });
    },
    
    saveModalContent() {
        if (!this.editorInstance) return;
        
        let content = this.editorInstance.getData();
        let csrf = document.querySelector('meta[name=csrf-token]').content;
        
        fetch('/admin/api/pages/store-or-update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf
            },
            body: JSON.stringify({
                slug: this.currentSlug,
                title: this.modalTitle,
                content: content
            })
        })
        .then(res => res.json())
        .then(data => {
            this.showModal = false;
            Swal.fire({
                icon: 'success',
                title: 'Başarılı!',
                text: 'Sayfa içeriği kaydedildi.',
                timer: 2000
            });
        })
        .catch(() => {
            Swal.fire({
                icon: 'error',
                title: 'Hata!',
                text: 'İçerik kaydedilemedi.'
            });
        });
    },
    
    closeModal() {
        this.showModal = false;
        if (this.editorInstance) {
            this.editorInstance.setData('');
        }
    }
}" 
x-init="
    CKEDITOR.replace('contentEditor', {
        height: 400,
        language: 'tr',
        removePlugins: 'exportpdf'
    });
    editorInstance = CKEDITOR.instances.contentEditor;
"
class="container mx-auto px-4 py-6">

    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Site Ayarları</h1>
        <p class="text-gray-600 mt-1">Site genelindeki ayarları buradan yönetebilirsiniz</p>
    </div>

    <!-- Tabs Navigation -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="flex border-b border-gray-200">
            <button type="button" 
                    @click="activeTab = 'general'"
                    :class="activeTab === 'general' ? 'bg-red-600 text-white border-b-2 border-red-600' : 'bg-white text-gray-700 hover:bg-gray-50'"
                    class="flex-1 px-6 py-4 text-sm font-semibold transition-colors">
                Genel Ayarlar
            </button>
            <button type="button" 
                    @click="activeTab = 'contact'"
                    :class="activeTab === 'contact' ? 'bg-red-600 text-white border-b-2 border-red-600' : 'bg-white text-gray-700 hover:bg-gray-50'"
                    class="flex-1 px-6 py-4 text-sm font-semibold transition-colors border-l border-gray-200">
                İletişim & Sosyal Medya
            </button>
            <button type="button" 
                    @click="activeTab = 'footer'"
                    :class="activeTab === 'footer' ? 'bg-red-600 text-white border-b-2 border-red-600' : 'bg-white text-gray-700 hover:bg-gray-50'"
                    class="flex-1 px-6 py-4 text-sm font-semibold transition-colors border-l border-gray-200">
                Footer Yönetimi
            </button>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Tab Content: Genel Ayarlar -->
            <div x-show="activeTab === 'general'" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 class="p-6 space-y-6">
                
                <h3 class="text-lg font-bold text-gray-900 mb-4">Genel Site Bilgileri</h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Site Başlığı</label>
                    <input type="text" 
                           name="site_title" 
                           value="{{ $settings['site_title'] ?? 'GMSGARAGE' }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                           placeholder="Örn: GMSGARAGE">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Site Açıklaması (SEO)</label>
                    <textarea name="site_description" 
                              rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                              placeholder="Site açıklaması (Google'da görünecek)">{{ $settings['site_description'] ?? '' }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Anahtar Kelimeler (SEO)</label>
                    <input type="text" 
                           name="site_keywords" 
                           value="{{ $settings['site_keywords'] ?? '' }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                           placeholder="Örn: araba, satılık araç, oto galeri">
                </div>
            </div>

            <!-- Tab Content: İletişim & Sosyal Medya -->
            <div x-show="activeTab === 'contact'" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 class="p-6">
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- İletişim Bilgileri -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">İletişim Bilgileri</h3>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Telefon Numarası</label>
                            <input type="text" 
                                   name="contact_phone" 
                                   value="{{ $settings['contact_phone'] ?? '' }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                   placeholder="0555 123 45 67">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">E-posta Adresi</label>
                            <input type="email" 
                                   name="contact_email" 
                                   value="{{ $settings['contact_email'] ?? '' }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                   placeholder="info@gmsgarage.com">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">WhatsApp Numarası</label>
                            <input type="text" 
                                   name="contact_whatsapp" 
                                   value="{{ $settings['contact_whatsapp'] ?? '' }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                   placeholder="905551234567">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Adres</label>
                            <textarea name="contact_address" 
                                      rows="3"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                      placeholder="Şirket adresi">{{ $settings['contact_address'] ?? '' }}</textarea>
                        </div>
                    </div>

                    <!-- Sosyal Medya -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Sosyal Medya Hesapları</h3>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Instagram</label>
                            <input type="text" 
                                   name="social_instagram" 
                                   value="{{ $settings['social_instagram'] ?? '' }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                   placeholder="https://instagram.com/gmsgarage">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Facebook</label>
                            <input type="text" 
                                   name="social_facebook" 
                                   value="{{ $settings['social_facebook'] ?? '' }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                   placeholder="https://facebook.com/gmsgarage">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Twitter (X)</label>
                            <input type="text" 
                                   name="social_twitter" 
                                   value="{{ $settings['social_twitter'] ?? '' }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                   placeholder="https://twitter.com/gmsgarage">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">YouTube</label>
                            <input type="text" 
                                   name="social_youtube" 
                                   value="{{ $settings['social_youtube'] ?? '' }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                   placeholder="https://youtube.com/@gmsgarage">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">LinkedIn</label>
                            <input type="text" 
                                   name="social_linkedin" 
                                   value="{{ $settings['social_linkedin'] ?? '' }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                   placeholder="https://linkedin.com/company/gmsgarage">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Content: Footer Yönetimi -->
            <div x-show="activeTab === 'footer'" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 class="p-6 space-y-6">
                
                <h3 class="text-lg font-bold text-gray-900 mb-4">Footer Metni</h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Copyright Metni</label>
                    <textarea name="footer_copyright" 
                              rows="2"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                              placeholder="© 2026 GMSGARAGE. Tüm hakları saklıdır.">{{ $settings['footer_copyright'] ?? '© 2026 GMSGARAGE. Tüm hakları saklıdır.' }}</textarea>
                </div>

                <div class="border-t pt-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Yasal Linkler ve Sayfa İçerikleri</h3>
                        <button type="button" 
                                @click="addLink()"
                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Yeni Link Ekle
                        </button>
                    </div>

                    <div class="space-y-3">
                        <template x-for="(link, index) in footerLinks" :key="index">
                            <div class="flex gap-3 items-center bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <div class="flex-1">
                                    <input type="text" 
                                           x-model="link.label"
                                           @input="updateUrl(index)"
                                           :name="'footer_bottom_links[' + index + '][label]'"
                                           placeholder="Başlık (Örn: KVKK)"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm">
                                </div>
                                
                                <div class="flex-1">
                                    <input type="text" 
                                           x-model="link.url"
                                           :name="'footer_bottom_links[' + index + '][url]'"
                                           readonly
                                           placeholder="URL (otomatik oluşur)"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600 text-sm cursor-not-allowed">
                                </div>
                                
                                <button type="button" 
                                        @click="openContentModal(index)"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2 whitespace-nowrap text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    İçeriği Düzenle
                                </button>
                                
                                <button type="button" 
                                        @click="removeLink(index)"
                                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors flex items-center gap-2 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Sil
                                </button>
                            </div>
                        </template>

                        <p x-show="footerLinks.length === 0" class="text-center text-gray-500 py-8">
                            Henüz link eklenmedi. "Yeni Link Ekle" butonuna tıklayarak başlayın.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end">
                <button type="submit" 
                        class="px-8 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                    </svg>
                    Ayarları Kaydet
                </button>
            </div>
        </form>
    </div>

    <!-- Modal: İçerik Düzenleme -->
    <div x-show="showModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
         style="display: none;"
         @click.self="closeModal()">
        
        <div class="bg-white rounded-lg shadow-2xl w-full max-w-5xl max-h-[90vh] flex flex-col"
             @click.stop>
            
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-900" x-text="modalTitle + ' - İçerik Düzenleme'"></h3>
                <button type="button" 
                        @click="closeModal()"
                        class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="flex-1 overflow-auto p-6">
                <textarea id="contentEditor" name="content"></textarea>
            </div>
            
            <!-- Modal Footer -->
            <div class="flex items-center justify-end gap-3 p-6 border-t border-gray-200 bg-gray-50">
                <button type="button" 
                        @click="closeModal()"
                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors">
                    İptal
                </button>
                <button type="button" 
                        @click="saveModalContent()"
                        class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                    </svg>
                    İçeriği Kaydet
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- CKEditor 4 (Standard-All) -->
<script src="https://cdn.ckeditor.com/4.22.1/standard-all/ckeditor.js"></script>
@endpush
