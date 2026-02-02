@extends('admin.layouts.app')

@section('title', $email['subject'] . ' - Mail Detayı')
@section('page-title', 'Mail Detayı')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600">Dashboard</a>
    <span>/</span>
    <a href="{{ route('admin.mailbox.index') }}" class="hover:text-primary-600">Mail Kutusu</a>
    <span>/</span>
    <a href="{{ route('admin.mailbox.' . strtolower($folder == 'INBOX' ? 'inbox' : ($folder == 'Sent' ? 'sent' : 'trash'))) }}" class="hover:text-primary-600">{{ $folder_name }}</a>
    <span>/</span>
    <span>Detay</span>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex items-start justify-between mb-4">
            <div class="flex-1">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $email['subject'] }}</h2>
                <div class="flex items-center gap-4 text-sm text-gray-600">
                    <span><strong>Gönderen:</strong> {{ $email['from_name'] }} &lt;{{ $email['from_email'] }}&gt;</span>
                </div>
                <div class="flex items-center gap-4 text-sm text-gray-600 mt-1">
                    <span><strong>Alıcı:</strong> {{ $email['to_name'] }} &lt;{{ $email['to_email'] }}&gt;</span>
                </div>
                <div class="text-sm text-gray-500 mt-2">
                    {{ date('d.m.Y H:i:s', $email['timestamp']) }}
                </div>
            </div>
            <a href="{{ route('admin.mailbox.' . strtolower($folder == 'INBOX' ? 'inbox' : ($folder == 'Sent' ? 'sent' : 'trash'))) }}" class="px-4 py-2 text-sm font-semibold bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                ← Geri Dön
            </a>
        </div>
    </div>

    <!-- Body -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        @if($email['body_html'])
            <div class="prose max-w-none">
                {!! $email['body_html'] !!}
            </div>
        @elseif($email['body_text'])
            <div class="whitespace-pre-wrap text-gray-700">
                {{ $email['body_text'] }}
            </div>
        @else
            <p class="text-gray-500 italic">E-posta içeriği yüklenemedi.</p>
        @endif
    </div>
</div>
@endsection
