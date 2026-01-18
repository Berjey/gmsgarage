@extends('admin.layouts.app')

@section('content')
<div class="bg-white dark:bg-[#252525] rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Mesaj Detayı</h2>
        <a href="{{ route('admin.contact-messages.index') }}" class="text-primary-600 hover:text-primary-900 dark:text-primary-400">← Geri</a>
    </div>

    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">İsim</label>
                <p class="text-gray-900 dark:text-gray-100 font-medium">{{ $message->name }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">E-posta</label>
                <p class="text-gray-900 dark:text-gray-100">{{ $message->email }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Telefon</label>
                <p class="text-gray-900 dark:text-gray-100">{{ $message->phone ?? 'Belirtilmemiş' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Tarih</label>
                <p class="text-gray-900 dark:text-gray-100">{{ $message->created_at->format('d.m.Y H:i') }}</p>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Konu</label>
            <p class="text-gray-900 dark:text-gray-100">{{ $message->subject ?? 'Konu yok' }}</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Mesaj</label>
            <div class="mt-2 p-4 bg-gray-50 dark:bg-[#1e1e1e] rounded-lg text-gray-900 dark:text-gray-100 whitespace-pre-wrap">{{ $message->message }}</div>
        </div>

        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-800">
            <form action="{{ route('admin.contact-messages.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Bu mesajı silmek istediğinize emin misiniz?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition-colors">Sil</button>
            </form>
        </div>
    </div>
</div>
@endsection
