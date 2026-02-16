@extends('admin.layouts.app')

@section('title', 'Kullanıcı Yönetimi - Admin Panel')
@section('page-title', 'Kullanıcı Yönetimi')
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600">Dashboard</a>
    <span>/</span>
    <span>Kullanıcılar</span>
@endsection

@section('content')
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-200 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Kullanıcılar</h2>
            <p class="text-sm text-gray-600 mt-1">Sistem kullanıcılarını yönetin</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-semibold transition-colors flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Yeni Kullanıcı
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Ad Soyad</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">E-posta</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Rol</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tarih</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">İşlemler</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($users as $user)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-primary-100 text-primary-700 rounded-full flex items-center justify-center font-bold">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="text-sm font-bold text-gray-900">{{ $user->name }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        {{ $user->email }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $badgeColors = [
                                'admin' => 'bg-red-100 text-red-800',
                                'manager' => 'bg-blue-100 text-blue-800',
                                'editor' => 'bg-green-100 text-green-800',
                            ];
                            $badgeColor = $badgeColors[$user->role] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $badgeColor }}">
                            {{ $user->role_name }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $user->created_at->format('d.m.Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="p-2.5 text-amber-600 bg-amber-50 rounded-xl hover:bg-amber-600 hover:text-white transition-all shadow-sm" title="Düzenle">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirmDelete(this, '{{ $user->name }} kullanıcısını')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2.5 text-red-600 bg-red-50 rounded-xl hover:bg-red-600 hover:text-white transition-all shadow-sm {{ auth()->id() == $user->id ? 'opacity-50 cursor-not-allowed' : '' }}" {{ auth()->id() == $user->id ? 'disabled' : '' }} title="Sil">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
