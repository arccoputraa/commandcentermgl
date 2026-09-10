@extends('layouts.division_base')
@section('title', 'Dashboard Perizinan')

@section('sidebar_menu')
<a href="{{ route('perizinan.dashboard') }}" class="menu-item {{ request()->routeIs('perizinan.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie"></i> Dashboard Perizinan
            </a>
            <a href="{{ route('perizinan.data.index') }}" class="menu-item {{ request()->routeIs('perizinan.data.*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-lines"></i> Daftar Data Perizinan
            </a>
            <a href="{{ route('perizinan.jenis.index') }}" class="menu-item {{ request()->routeIs('perizinan.jenis.*') ? 'active' : '' }}">
                <i class="fa-solid fa-tags"></i> Jenis Izin & SLA
            </a>
            <a href="{{ route('perizinan.publikasi.index') }}" class="menu-item {{ request()->routeIs('perizinan.publikasi.*') ? 'active' : '' }}">
                <i class="fa-solid fa-bullhorn"></i> Publikasi Masyarakat
            </a>
            
            @if(Auth::user()->isSuperAdmin() || Auth::user()->isDivisionAdmin())
            <a href="{{ route('division.users.index', 'perizinan') }}" class="menu-item {{ request()->routeIs('division.users.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users-gear"></i> Manajemen User
            </a>
            @endif
            <a href="{{ route('profile.index') }}" class="menu-item {{ request()->routeIs('profile.index') ? 'active' : '' }}">
                <i class="fa-solid fa-user-circle"></i> Profil
            </a>
@endsection
