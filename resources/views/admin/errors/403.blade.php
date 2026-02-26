@extends('admin.layouts.app')

@section('title', 'Erişim Reddedildi - Admin Panel')
@section('page-title', 'Erişim Reddedildi')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600">Dashboard</a>
    <span>/</span>
    <span class="text-red-500">403 Erişim Reddedildi</span>
@endsection

@section('content')
    <x-admin.access-denied :message="$errorMessage ?? 'Bu sayfaya erişim yetkiniz yok.'" />
@endsection
