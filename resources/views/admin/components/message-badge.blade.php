@props(['isRead'])

@if($isRead)
    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-700 border-2 border-gray-200 hover:bg-gray-200 active:bg-gray-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-400 focus-visible:ring-offset-1 transition-all duration-150">
        Okundu
    </span>
@else
    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-green-100 text-green-800 border-2 border-green-300 hover:bg-green-200 active:bg-green-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-green-500 focus-visible:ring-offset-1 transition-all duration-150 shadow-sm">
        <span class="w-1.5 h-1.5 bg-green-600 rounded-full mr-1.5 animate-pulse"></span>
        Yeni
    </span>
@endif
