@extends('layouts.division_base')
@section('title', 'Dashboard SIG')

@section('sidebar_menu')
<a href="{{ route('sig.dashboard') }}" class="menu-item {{ request()->routeIs('sig.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie"></i> Dashboard SIG
            </a>
            <a href="{{ route('sig.layer.index') }}" class="menu-item {{ request()->routeIs('sig.layer.*') ? 'active' : '' }}">
                <i class="fa-solid fa-layer-group"></i> Manajemen Layer
            </a>
            <a href="{{ route('sig.data-spasial.index') }}" class="menu-item {{ request()->routeIs('sig.data-spasial.*') ? 'active' : '' }}">
                <i class="fa-solid fa-map-location-dot"></i> Data Spasial
            </a>
            <a href="{{ route('sig.dokumen.index') }}" class="menu-item {{ request()->routeIs('sig.dokumen.*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-pdf"></i> Dokumen SIG
            </a>
            
            @if(Auth::user()->isSuperAdmin() || Auth::user()->isDivisionAdmin())
            <a href="{{ route('division.users.index', 'sig') }}" class="menu-item {{ request()->routeIs('division.users.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users-gear"></i> Manajemen User
            </a>
            @endif
            <a href="{{ route('profile.index') }}" class="menu-item {{ request()->routeIs('profile.index') ? 'active' : '' }}">
                <i class="fa-solid fa-user-circle"></i> Profil
            </a>
@endsection
