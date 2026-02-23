@php
    // Formlarda gösterilmesi gereken yasal sayfaları çek
    $formPages = \App\Models\LegalPage::getFormPages();
@endphp

@if($formPages->count() > 0)
    <div class="space-y-3">
        @foreach($formPages as $page)
        <div class="bg-gray-50 dark:bg-neutral-900 border-2 border-gray-200 dark:border-neutral-800 rounded-lg p-4 transition-colors" id="consent-box-{{ $page->slug }}-{{ $formId ?? 'default' }}">
            <div class="flex items-start space-x-3">
                {{-- Checkbox: click blocked until user reads modal (data-needs-reading) --}}
                <input type="checkbox" 
                       name="legal_consent_{{ $page->slug }}" 
                       id="legal-{{ $page->slug }}-{{ $formId ?? 'default' }}" 
                       data-needs-reading="true"
                       class="mt-1 w-5 h-5 text-red-600 border-gray-300 dark:border-neutral-600 rounded focus:ring-2 focus:ring-red-500 dark:bg-neutral-950 dark:focus:ring-red-600 opacity-40 cursor-not-allowed">
                <span class="flex-1 text-sm text-gray-700 dark:text-neutral-300">
                    Önce 
                    <a href="#" 
                       data-legal-slug="{{ $page->slug }}" 
                       data-checkbox-id="legal-{{ $page->slug }}-{{ $formId ?? 'default' }}" 
                       class="text-red-600 dark:text-red-500 hover:text-red-700 dark:hover:text-red-400 font-semibold underline">
                        {{ $page->title }}
                    </a>'ni okuyun, ardından onaylayın. <span class="text-red-500">*</span>
                </span>
            </div>
            <span class="text-red-500 text-xs mt-1 hidden" id="error-{{ $page->slug }}-{{ $formId ?? 'default' }}"></span>
        </div>
        @endforeach
    </div>
@endif
