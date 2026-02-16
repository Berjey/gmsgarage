@props(['totalCount', 'unreadCount', 'readCount', 'activeFilter'])

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <!-- Toplam Mesaj -->
    <a href="{{ route('admin.contact-messages.index', ['filter' => 'all'] + request()->except('filter')) }}" 
       class="group block p-6 bg-gray-50/50 border-2 {{ $activeFilter === 'all' ? 'border-primary-600' : 'border-transparent' }} rounded-xl hover:bg-gray-100/50 transition-all">
        <div class="flex items-center justify-between mb-3">
            <div class="text-xs font-bold text-gray-500 uppercase tracking-widest">Toplam Mesaj</div>
            <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
        </div>
        <div class="text-3xl font-bold text-gray-900">{{ $totalCount }}</div>
    </a>
    
    <!-- Okunmamış -->
    <a href="{{ route('admin.contact-messages.index', ['filter' => 'unread'] + request()->except('filter')) }}" 
       class="group block p-6 bg-gray-50/50 border-2 {{ $activeFilter === 'unread' ? 'border-primary-600' : 'border-transparent' }} rounded-xl hover:bg-gray-100/50 transition-all">
        <div class="flex items-center justify-between mb-3">
            <div class="text-xs font-bold text-gray-500 uppercase tracking-widest">Okunmamış</div>
            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            </div>
        </div>
        <div class="text-3xl font-bold text-gray-900">{{ $unreadCount }}</div>
    </a>
    
    <!-- Okunmuş -->
    <a href="{{ route('admin.contact-messages.index', ['filter' => 'read'] + request()->except('filter')) }}" 
       class="group block p-6 bg-gray-50/50 border-2 {{ $activeFilter === 'read' ? 'border-primary-600' : 'border-transparent' }} rounded-xl hover:bg-gray-100/50 transition-all">
        <div class="flex items-center justify-between mb-3">
            <div class="text-xs font-bold text-gray-500 uppercase tracking-widest">Okunmuş</div>
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
        <div class="text-3xl font-bold text-gray-900">{{ $readCount }}</div>
    </a>
</div>
