@props([
    'title' => '',
    'value' => 0,
    'subtitle' => '',
    'trend' => null,
    'trendDirection' => 'up', // up, down, neutral
    'icon' => 'chart',
    'color' => 'primary', // primary, success, warning, danger, info
    'link' => null,
    'animate' => true
])

@php
    $colorClasses = [
        'primary' => [
            'bg' => 'bg-primary-100',
            'text' => 'text-primary-600',
            'hover' => 'hover:shadow-primary-500/20'
        ],
        'success' => [
            'bg' => 'bg-green-100',
            'text' => 'text-green-600',
            'hover' => 'hover:shadow-green-500/20'
        ],
        'warning' => [
            'bg' => 'bg-yellow-100',
            'text' => 'text-yellow-600',
            'hover' => 'hover:shadow-yellow-500/20'
        ],
        'danger' => [
            'bg' => 'bg-red-100',
            'text' => 'text-red-600',
            'hover' => 'hover:shadow-red-500/20'
        ],
        'info' => [
            'bg' => 'bg-blue-100',
            'text' => 'text-blue-600',
            'hover' => 'hover:shadow-blue-500/20'
        ]
    ];

    $currentColor = $colorClasses[$color] ?? $colorClasses['primary'];
    
    $trendColorClass = match($trendDirection) {
        'up' => 'text-green-600 bg-green-50',
        'down' => 'text-red-600 bg-red-50',
        default => 'text-gray-600 bg-gray-50'
    };

    $icons = [
        'vehicle' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
        'blog' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z',
        'user' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
        'message' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
        'chart' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
        'eye' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z',
        'check' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
        'star' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z',
        'clipboard' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'
    ];

    $iconPath = $icons[$icon] ?? $icons['chart'];
    $wrapperTag = $link ? 'a' : 'div';
@endphp

<{{ $wrapperTag }} 
    @if($link) href="{{ $link }}" @endif
    class="stat-card bg-white rounded-xl p-6 border border-gray-200 shadow-sm transition-all duration-300 hover:shadow-lg {{ $currentColor['hover'] }} {{ $animate ? 'opacity-0' : '' }} {{ $link ? 'cursor-pointer hover:-translate-y-1' : '' }}"
>
    <div class="flex items-center justify-between">
        <div class="flex-1">
            <p class="text-sm font-semibold text-gray-600 mb-2">{{ $title }}</p>
            <div class="flex items-baseline space-x-2">
                <p class="text-3xl font-bold text-gray-900">{{ $value }}</p>
                @if($trend)
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $trendColorClass }}">
                        @if($trendDirection === 'up')
                            <svg class="w-3 h-3 mr-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                        @elseif($trendDirection === 'down')
                            <svg class="w-3 h-3 mr-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        @endif
                        {{ $trend }}
                    </span>
                @endif
            </div>
            @if($subtitle)
                <p class="text-xs text-gray-500 mt-2">{{ $subtitle }}</p>
            @endif
        </div>
        <div class="w-14 h-14 {{ $currentColor['bg'] }} rounded-xl flex items-center justify-center transition-transform duration-300 group-hover:scale-110">
            @if($icon === 'star')
                <svg class="w-7 h-7 {{ $currentColor['text'] }}" fill="currentColor" viewBox="0 0 20 20">
                    <path d="{{ $iconPath }}"/>
                </svg>
            @else
                <svg class="w-7 h-7 {{ $currentColor['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPath }}"/>
                </svg>
            @endif
        </div>
    </div>
</{{ $wrapperTag }}>

@if($animate)
@push('styles')
<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .stat-card {
        animation: fadeInUp 0.5s ease-out forwards;
    }
    
    .stat-card:nth-child(1) { animation-delay: 0.05s; }
    .stat-card:nth-child(2) { animation-delay: 0.1s; }
    .stat-card:nth-child(3) { animation-delay: 0.15s; }
    .stat-card:nth-child(4) { animation-delay: 0.2s; }
    .stat-card:nth-child(5) { animation-delay: 0.25s; }
    .stat-card:nth-child(6) { animation-delay: 0.3s; }
    .stat-card:nth-child(7) { animation-delay: 0.35s; }
    .stat-card:nth-child(8) { animation-delay: 0.4s; }
    .stat-card:nth-child(9) { animation-delay: 0.45s; }
</style>
@endpush
@endif
