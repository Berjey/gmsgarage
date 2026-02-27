{{--
    Tekil E-Posta Gönder Modal
    Props:
      $modalId        — HTML id (string, unique per page)
      $postUrl        — AJAX POST URL
      $recipientEmail — Alıcı e-posta adresi (otomatik dolu)
      $recipientName  — Alıcı adı
      $defaultSubject — Varsayılan konu (opsiyonel)
--}}
@props([
    'modalId'        => 'send-email-modal',
    'postUrl'        => '',
    'recipientEmail' => '',
    'recipientName'  => '',
    'defaultSubject' => '',
])

<div id="{{ $modalId }}"
     class="hidden fixed inset-0 z-50 overflow-y-auto"
     aria-labelledby="{{ $modalId }}-title"
     role="dialog"
     aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        {{-- Backdrop --}}
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity"
             onclick="closeSendEmailModal('{{ $modalId }}')"></div>

        {{-- Modal Panel --}}
        <div class="relative inline-block align-middle bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all w-full max-w-lg">
            {{-- Header --}}
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-900" id="{{ $modalId }}-title">E-Posta Gönder</h3>
                    <p class="text-sm text-gray-500 mt-0.5">Seçili kişiye e-posta gönderin.</p>
                </div>
                <button type="button"
                        onclick="closeSendEmailModal('{{ $modalId }}')"
                        class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Body --}}
            <div class="px-6 py-5 space-y-4">
                {{-- Alıcı (readonly) --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Alıcı</label>
                    <input type="text"
                           value="{{ $recipientName }} &lt;{{ $recipientEmail }}&gt;"
                           readonly
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50 text-gray-500 text-sm cursor-not-allowed">
                </div>

                {{-- Konu --}}
                <div>
                    <label for="{{ $modalId }}-subject" class="block text-sm font-bold text-gray-700 mb-1.5">
                        E-posta Konusu <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="{{ $modalId }}-subject"
                           placeholder="Örn: Değerleme Talebiniz Hakkında"
                           value="{{ $defaultSubject }}"
                           maxlength="255"
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all text-sm">
                </div>

                {{-- Mesaj --}}
                <div>
                    <label for="{{ $modalId }}-message" class="block text-sm font-bold text-gray-700 mb-1.5">
                        Mesaj <span class="text-red-500">*</span>
                    </label>
                    <textarea id="{{ $modalId }}-message"
                              rows="6"
                              placeholder="E-posta içeriğinizi buraya yazın..."
                              class="w-full px-4 py-2.5 border border-gray-200 rounded-xl bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all resize-none text-sm"></textarea>
                    <p class="mt-1 text-xs text-gray-400">Not: HTML etiketleri desteklenmez, düz metin olarak gönderilir.</p>
                </div>

                {{-- Alıcı bilgisi --}}
                <div class="flex items-center gap-2 px-4 py-3 bg-blue-50 border border-blue-100 rounded-xl">
                    <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-semibold text-blue-700">
                        Gönderilecek adres: <span class="font-bold">{{ $recipientEmail }}</span>
                    </span>
                </div>
            </div>

            {{-- Footer --}}
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-3">
                <button type="button"
                        onclick="closeSendEmailModal('{{ $modalId }}')"
                        class="px-5 py-2.5 bg-white text-gray-700 font-bold rounded-xl border border-gray-200 hover:bg-gray-50 transition-all text-sm">
                    İptal
                </button>
                <button type="button"
                        id="{{ $modalId }}-submit-btn"
                        onclick="submitSendEmailModal('{{ $modalId }}', '{{ $postUrl }}', '{{ $recipientEmail }}')"
                        class="px-5 py-2.5 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 transition-all shadow-sm flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    E-posta Gönder
                </button>
            </div>
        </div>
    </div>
</div>
