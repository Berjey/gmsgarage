@extends('layouts.app')

@section('title', $page->meta_title ?? $page->title)
@section('description', $page->meta_description ?? $page->excerpt ?? strip_tags(substr($page->content, 0, 160)))
@section('keywords', $page->meta_keywords ?? '')

@push('styles')
<style>
/* Legal Content Styling - CKEditor Output */
.legal-content {
    color: #374151;
    line-height: 1.75;
    font-size: 1.125rem;
}

.dark .legal-content {
    color: #d1d5db;
}

/* Headings */
.legal-content h1, .legal-content h2, .legal-content h3, .legal-content h4 {
    font-weight: 700;
    margin-top: 2rem;
    margin-bottom: 1rem;
    color: #111827;
}

.dark .legal-content h1, .dark .legal-content h2, .dark .legal-content h3, .dark .legal-content h4 {
    color: #ffffff;
}

.legal-content h2 {
    font-size: 1.875rem;
    border-bottom: 2px solid #e5e7eb;
    padding-bottom: 0.75rem;
    margin-top: 3rem;
}

.dark .legal-content h2 {
    border-bottom-color: #374151;
}

.legal-content h3 {
    font-size: 1.5rem;
    margin-top: 2rem;
}

.legal-content h4 {
    font-size: 1.25rem;
    margin-top: 1.5rem;
}

/* Paragraphs */
.legal-content p {
    margin-top: 1.25rem;
    margin-bottom: 1.25rem;
    line-height: 1.8;
}

/* Lists */
.legal-content ul, .legal-content ol {
    margin-top: 1.25rem;
    margin-bottom: 1.25rem;
    padding-left: 2rem;
}

.legal-content ul {
    list-style-type: disc;
}

.legal-content ol {
    list-style-type: decimal;
}

.legal-content li {
    margin-top: 0.5rem;
    margin-bottom: 0.5rem;
    padding-left: 0.5rem;
    line-height: 1.75;
}

.legal-content li::marker {
    color: #dc2626;
}

.dark .legal-content li::marker {
    color: #ef4444;
}

/* Nested Lists */
.legal-content ul ul, .legal-content ul ol, .legal-content ol ul, .legal-content ol ol {
    margin-top: 0.5rem;
    margin-bottom: 0.5rem;
}

/* Links */
.legal-content a {
    color: #dc2626;
    text-decoration: none;
    font-weight: 600;
}

.legal-content a:hover {
    text-decoration: underline;
}

.dark .legal-content a {
    color: #ef4444;
}

/* Strong/Bold */
.legal-content strong, .legal-content b {
    font-weight: 700;
    color: #111827;
}

.dark .legal-content strong, .dark .legal-content b {
    color: #ffffff;
}

/* Emphasis/Italic */
.legal-content em, .legal-content i {
    font-style: italic;
}

/* Code */
.legal-content code {
    background-color: #f3f4f6;
    color: #dc2626;
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    font-family: 'Courier New', monospace;
}

.dark .legal-content code {
    background-color: #1f2937;
    color: #ef4444;
}

/* Blockquote */
.legal-content blockquote {
    border-left: 4px solid #dc2626;
    padding-left: 1.5rem;
    margin: 1.5rem 0;
    font-style: italic;
    color: #6b7280;
}

.dark .legal-content blockquote {
    border-left-color: #ef4444;
    color: #9ca3af;
}

/* Tables */
.legal-content table {
    width: 100%;
    margin: 2rem 0;
    border-collapse: collapse;
}

.legal-content th, .legal-content td {
    border: 1px solid #e5e7eb;
    padding: 0.75rem 1rem;
    text-align: left;
}

.dark .legal-content th, .dark .legal-content td {
    border-color: #374151;
}

.legal-content th {
    background-color: #f9fafb;
    font-weight: 700;
    color: #111827;
}

.dark .legal-content th {
    background-color: #1f2937;
    color: #ffffff;
}

/* HR */
.legal-content hr {
    margin: 2rem 0;
    border-top: 1px solid #e5e7eb;
}

.dark .legal-content hr {
    border-top-color: #374151;
}

/* Images */
.legal-content img {
    max-width: 100%;
    height: auto;
    border-radius: 0.5rem;
    margin: 2rem 0;
}

/* First Paragraph larger */
.legal-content > p:first-of-type {
    font-size: 1.25rem;
    color: #4b5563;
    margin-top: 0;
}

.dark .legal-content > p:first-of-type {
    color: #9ca3af;
}
</style>
@endpush

@section('content')
<div class="bg-gradient-to-br from-gray-50 via-white to-gray-50 dark:from-[#0d0d0d] dark:via-[#1e1e1e] dark:to-[#0d0d0d] min-h-screen py-12 transition-colors duration-200">
    <div class="container-custom">
        <!-- Breadcrumb -->
        <nav class="mb-8" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                <li>
                    <a href="{{ route('home') }}" class="hover:text-red-600 dark:hover:text-red-400 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </a>
                </li>
                <li>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </li>
                <li class="text-gray-900 dark:text-white font-medium">
                    {{ $page->title }}
                </li>
            </ol>
        </nav>

        <!-- Page Content -->
        <div class="bg-white dark:bg-[#1e1e1e] rounded-2xl shadow-xl overflow-hidden transition-colors duration-200">
            <!-- Header -->
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-8 py-12 text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    {{ $page->title }}
                </h1>
                @if($page->excerpt)
                <p class="text-red-100 text-lg max-w-3xl mx-auto">
                    {{ $page->excerpt }}
                </p>
                @endif
            </div>

            <!-- Content -->
            <div class="px-8 md:px-16 py-12">
                <article class="legal-content max-w-none">
                    {!! $page->content !!}
                </article>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 dark:bg-[#0d0d0d] px-8 py-6 border-t border-gray-200 dark:border-gray-800 transition-colors duration-200">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Son Güncelleme: {{ $page->updated_at->format('d.m.Y') }}
                    </div>
                    
                    <a href="{{ route('home') }}" 
                       class="inline-flex items-center gap-2 px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-all duration-300 transform hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Ana Sayfaya Dön
                    </a>
                </div>
            </div>
        </div>

        <!-- İletişim CTA -->
        <div class="mt-12 bg-gradient-to-r from-red-600 to-red-700 rounded-2xl p-8 md:p-12 text-center shadow-xl">
            <h2 class="text-3xl font-bold text-white mb-4">
                Sorularınız mı var?
            </h2>
            <p class="text-red-100 mb-6 text-lg">
                Size yardımcı olmak için buradayız. Bizimle iletişime geçin.
            </p>
            <a href="{{ route('contact') }}" 
               class="inline-flex items-center gap-2 px-8 py-4 bg-white text-red-600 font-bold rounded-lg hover:bg-gray-100 transition-all duration-300 transform hover:scale-105">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                İletişime Geç
            </a>
        </div>
    </div>
</div>
@endsection
