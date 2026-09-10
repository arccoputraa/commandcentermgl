@extends('layouts.division_base')
@section('title', 'Dashboard Kependudukan')

@section('sidebar_menu')
<a href="{{ route('kependudukan.dashboard') }}" class="menu-item {{ request()->routeIs('kependudukan.dashboard') ? 'active' : '' }}">
    <i class="fa-solid fa-chart-pie"></i> Dashboard Kependudukan
</a>
<a href="{{ route('kependudukan.data-penduduk.index') }}" class="menu-item {{ request()->routeIs('kependudukan.data-penduduk.*') ? 'active' : '' }}">
    <i class="fa-solid fa-users"></i> Data Penduduk
</a>
<a href="{{ route('kependudukan.data-agama.index') }}" class="menu-item {{ request()->routeIs('kependudukan.data-agama.*') ? 'active' : '' }}">
    <i class="fa-solid fa-star-and-crescent"></i> Data Agama
</a>
<a href="{{ route('kependudukan.data-wilayah.index') }}" class="menu-item {{ request()->routeIs('kependudukan.data-wilayah.*') ? 'active' : '' }}">
    <i class="fa-solid fa-map-location-dot"></i> Data Wilayah
</a>
<a href="{{ route('kependudukan.data-kartu-keluarga.index') }}" class="menu-item {{ request()->routeIs('kependudukan.data-kartu-keluarga.*') ? 'active' : '' }}">
    <i class="fa-solid fa-address-card"></i> Data Kartu Keluarga
</a>
<a href="{{ route('kependudukan.mutasi-penduduk.index') }}" class="menu-item {{ request()->routeIs('kependudukan.mutasi-penduduk.*') ? 'active' : '' }}">
    <i class="fa-solid fa-right-left"></i> Mutasi Penduduk
</a>
<a href="{{ route('kependudukan.informasi-terbaru.index') }}" class="menu-item {{ request()->routeIs('kependudukan.informasi-terbaru.*') ? 'active' : '' }}">
    <i class="fa-solid fa-bullhorn"></i> Informasi Terbaru
</a>

@if(Auth::user()->isSuperAdmin() || Auth::user()->isDivisionAdmin())
<a href="{{ route('division.users.index', 'kependudukan') }}" class="menu-item {{ request()->routeIs('division.users.*') ? 'active' : '' }}">
    <i class="fa-solid fa-users-gear"></i> Manajemen User
</a>
@endif
<a href="{{ route('profile.index') }}" class="menu-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
    <i class="fa-solid fa-user-circle"></i> Profil
</a>
@endsection
