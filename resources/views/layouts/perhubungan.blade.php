@extends('layouts.division_base')
@section('title', 'Dashboard Perhubungan')

@section('sidebar_menu')
<a href="{{ route('perhubungan.dashboard') }}" class="menu-item {{ request()->routeIs('perhubungan.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie"></i> Dashboard Perhubungan
            </a>
            <a href="{{ route('perhubungan.ujikir.index') }}" class="menu-item {{ request()->routeIs('perhubungan.ujikir.*') ? 'active' : '' }}">
                <i class="fa-solid fa-truck"></i> Data Uji KIR
            </a>
            <a href="{{ route('perhubungan.dokumen.index') }}" class="menu-item {{ request()->routeIs('perhubungan.dokumen.*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-pdf"></i> Dokumen Laporan
            </a>
            
            @if(Auth::user()->isSuperAdmin() || Auth::user()->isDivisionAdmin())
            <a href="{{ route('division.users.index', 'perhubungan') }}" class="menu-item {{ request()->routeIs('division.users.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users-gear"></i> Manajemen User
            </a>
            @endif
            <a href="{{ route('profile.index') }}" class="menu-item {{ request()->routeIs('profile.index') ? 'active' : '' }}">
                <i class="fa-solid fa-user-circle"></i> Profil
            </a>
@endsection
