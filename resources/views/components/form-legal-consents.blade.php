@php
    // Formlarda gösterilmesi gereken yasal sayfaları çek
    $formPages = \App\Models\LegalPage::getFormPages();
@endphp

@if($formPages->count() > 0)
    <div class="space-y-3">
        @foreach($formPages as $page)
        <div class="bg-gray-50 dark:bg-neutral-900 border-2 border-gray-200 dark:border-neutral-800 rounded-lg p-4 transition-colors" id="consent-box-{{ $page->slug }}-{{ $formId ?? 'default' }}">
            <div class="flex items-start space-x-3">
                {{-- Checkbox: Opsiyonel sözleşmeler için direkt tıklanabilir --}}
                <input type="checkbox" 
                       name="legal_consent_{{ $page->slug }}" 
                       id="legal-{{ $page->slug }}-{{ $formId ?? 'default' }}" 
                       data-needs-reading="{{ $page->is_optional_in_forms ? 'false' : 'true' }}"
                       data-is-optional="{{ $page->is_optional_in_forms ? 'true' : 'false' }}"
                       class="mt-1 w-5 h-5 text-red-600 border-gray-300 dark:border-neutral-600 rounded focus:ring-2 focus:ring-red-500 dark:bg-neutral-950 dark:focus:ring-red-600 {{ $page->is_optional_in_forms ? 'cursor-pointer' : 'opacity-40 cursor-not-allowed' }}">
                <span class="flex-1 text-sm text-gray-700 dark:text-neutral-300">
                    @if($page->is_optional_in_forms)
                        <a href="#" 
                           data-legal-slug="{{ $page->slug }}" 
                           data-checkbox-id="legal-{{ $page->slug }}-{{ $formId ?? 'default' }}" 
                           class="text-red-600 dark:text-red-500 hover:text-red-700 dark:hover:text-red-400 font-semibold underline">
                            {{ $page->title }}
                        </a>'ni okuyun ve onaylayın. 
                        <span class="inline-block px-2 py-0.5 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 text-xs font-semibold rounded ml-2">İsteğe Bağlı</span>
                    @else
                        Önce 
                        <a href="#" 
                           data-legal-slug="{{ $page->slug }}" 
                           data-checkbox-id="legal-{{ $page->slug }}-{{ $formId ?? 'default' }}" 
                           class="text-red-600 dark:text-red-500 hover:text-red-700 dark:hover:text-red-400 font-semibold underline">
                            {{ $page->title }}
                        </a>'ni okuyun, ardından onaylayın. 
                        <span class="text-red-500">*</span>
                    @endif
                </span>
            </div>
            <span class="text-red-500 text-xs mt-1 hidden" id="error-{{ $page->slug }}-{{ $formId ?? 'default' }}"></span>
        </div>
        @endforeach
    </div>
@endif
