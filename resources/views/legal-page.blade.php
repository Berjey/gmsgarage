@extends('layouts.app')

@section('title', $page->title . ' - GMS Garage')
@section('meta_description', 'GMS Garage ' . $page->title)

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-4xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-sm text-gray-600 mb-6">
            <a href="{{ route('home') }}" class="hover:text-primary-600 transition-colors">Anasayfa</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-gray-900 font-semibold">{{ $page->title }}</span>
        </nav>

        <!-- Page Header -->
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 rounded-xl p-8 mb-8 text-white shadow-lg">
            <h1 class="text-3xl md:text-4xl font-bold mb-2">{{ $page->title }}</h1>
            <p class="text-primary-100 text-sm">Son güncelleme: {{ $page->updated_at->format('d.m.Y') }} | Versiyon: {{ $page->version }}</p>
        </div>

        <!-- Page Content -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 md:p-12">
            <div class="prose prose-lg max-w-none legal-content">
                {!! $page->content !!}
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-8 text-center">
            <a href="javascript:history.back()" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-semibold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Geri Dön
            </a>
        </div>
    </div>
</div>

<style>
.legal-content h2 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.legal-content h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #374151;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
}

.legal-content p {
    margin-bottom: 1rem;
    line-height: 1.75;
    color: #4b5563;
}

.legal-content ul, .legal-content ol {
    margin-left: 1.5rem;
    margin-bottom: 1rem;
}

.legal-content li {
    margin-bottom: 0.5rem;
    line-height: 1.75;
    color: #4b5563;
}

.legal-content strong {
    color: #1f2937;
    font-weight: 600;
}

.legal-content em {
    color: #6b7280;
}
</style>
@endsection
