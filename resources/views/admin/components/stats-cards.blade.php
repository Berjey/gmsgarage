@props(['totalCount', 'unreadCount', 'readCount', 'activeFilter'])

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <!-- Toplam Mesaj -->
    <a href="{{ route('admin.contact-messages.index', ['filter' => 'all'] + request()->except('filter')) }}" 
       class="group block p-5 bg-white border border-primary-600 rounded-xl hover:border-primary-700 transition-all shadow-sm hover:shadow-md {{ $activeFilter === 'all' ? 'ring-2 ring-primary-500 ring-offset-2' : '' }}">
        <div class="text-xs font-semibold text-gray-700 mb-1 uppercase tracking-wide">Toplam Mesaj</div>
        <div class="text-3xl font-bold text-primary-600">{{ $totalCount }}</div>
    </a>
    
    <!-- Okunmamış -->
    <a href="{{ route('admin.contact-messages.index', ['filter' => 'unread'] + request()->except('filter')) }}" 
       class="group block p-5 bg-white border border-primary-600 rounded-xl hover:border-primary-700 transition-all shadow-sm hover:shadow-md {{ $activeFilter === 'unread' ? 'ring-2 ring-primary-500 ring-offset-2' : '' }}">
        <div class="text-xs font-semibold text-gray-700 mb-1 uppercase tracking-wide">Okunmamış</div>
        <div class="text-3xl font-bold text-primary-600">{{ $unreadCount }}</div>
    </a>
    
    <!-- Okunmuş -->
    <a href="{{ route('admin.contact-messages.index', ['filter' => 'read'] + request()->except('filter')) }}" 
       class="group block p-5 bg-white border border-primary-600 rounded-xl hover:border-primary-700 transition-all shadow-sm hover:shadow-md {{ $activeFilter === 'read' ? 'ring-2 ring-primary-500 ring-offset-2' : '' }}">
        <div class="text-xs font-semibold text-gray-700 mb-1 uppercase tracking-wide">Okunmuş</div>
        <div class="text-3xl font-bold text-primary-600">{{ $readCount }}</div>
    </a>
</div>
