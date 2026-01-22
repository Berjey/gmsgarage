@props(['isRead'])

@if($isRead)
    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-primary-100 text-primary-800 border-2 border-primary-300 hover:bg-primary-200 active:bg-primary-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary-500 focus-visible:ring-offset-1 transition-all duration-150">
        Okundu
    </span>
@else
    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-primary-200 text-primary-900 border-2 border-primary-400 hover:bg-primary-300 active:bg-primary-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary-500 focus-visible:ring-offset-1 transition-all duration-150 shadow-sm">
        <span class="w-1.5 h-1.5 bg-primary-600 rounded-full mr-1.5 animate-pulse"></span>
        Yeni
    </span>
@endif
