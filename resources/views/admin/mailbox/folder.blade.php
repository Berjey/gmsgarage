@extends('admin.layouts.app')

@section('title', $folder_name . ' - Mail Kutusu')
@section('page-title', $folder_name)

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600">Dashboard</a>
    <span>/</span>
    <a href="{{ route('admin.mailbox.index') }}" class="hover:text-primary-600">Mail Kutusu</a>
    <span>/</span>
    <span>{{ $folder_name }}</span>
@endsection

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $folder_name }}</h2>
                <p class="text-sm text-gray-600 mt-1">{{ count($emails) }} e-posta</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.mailbox.inbox') }}" class="px-4 py-2 text-sm {{ $folder == 'INBOX' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700' }} rounded-lg font-semibold hover:bg-red-700 transition-colors">
                    Gelen Kutusu
                </a>
                <a href="{{ route('admin.mailbox.sent') }}" class="px-4 py-2 text-sm {{ $folder == 'Sent' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700' }} rounded-lg font-semibold hover:bg-red-700 transition-colors">
                    Giden Kutusu
                </a>
                <a href="{{ route('admin.mailbox.trash') }}" class="px-4 py-2 text-sm {{ $folder == 'Trash' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700' }} rounded-lg font-semibold hover:bg-red-700 transition-colors">
                    Silinen Kutusu
                </a>
            </div>
        </div>
    </div>

    <!-- Email List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if(count($emails) > 0)
            <div class="divide-y divide-gray-200">
                @foreach($emails as $email)
                <a href="{{ route('admin.mailbox.show', ['folder' => $folder, 'uid' => $email['uid']]) }}" class="flex items-center gap-4 p-4 hover:bg-gray-50 transition-colors {{ $email['unseen'] ? 'bg-blue-50' : '' }}">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-red-500 to-red-600 flex items-center justify-center text-white font-bold text-sm">
                            {{ strtoupper(substr($email['from_name'], 0, 1)) }}
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <p class="text-sm font-semibold text-gray-900 {{ $email['unseen'] ? 'font-bold' : '' }}">
                                {{ $email['from_name'] }}
                            </p>
                            <span class="text-xs text-gray-500">
                                {{ date('d.m.Y H:i', $email['date']) }}
                            </span>
                        </div>
                        <p class="text-sm font-medium text-gray-700 mb-1 {{ $email['unseen'] ? 'font-semibold' : '' }}">
                            {{ $email['subject'] }}
                        </p>
                        <p class="text-xs text-gray-500">{{ $email['from_email'] }}</p>
                    </div>
                    @if($email['unseen'])
                    <div class="flex-shrink-0">
                        <span class="w-2 h-2 bg-blue-600 rounded-full inline-block"></span>
                    </div>
                    @endif
                </a>
                @endforeach
            </div>
        @else
            <div class="p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <p class="text-gray-600 font-medium">Bu klasörde e-posta bulunmuyor.</p>
            </div>
        @endif
    </div>
</div>
@endsection
