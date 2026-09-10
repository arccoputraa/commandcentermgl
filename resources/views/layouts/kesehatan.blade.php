@extends('layouts.division_base')
@section('title', 'Dashboard Kesehatan')

@section('sidebar_menu')
<a href="{{ route('kesehatan.dashboard') }}" class="menu-item {{ request()->routeIs('kesehatan.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-notes-medical"></i> Dashboard Kesehatan
            </a>
            <a href="{{ route('kesehatan.program.index') }}" class="menu-item {{ request()->routeIs('kesehatan.program.*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-medical"></i> Daftar Program Kesehatan
            </a>
            <a href="{{ route('kesehatan.penyakit.index') }}" class="menu-item {{ request()->routeIs('kesehatan.penyakit.*') ? 'active' : '' }}">
                <i class="fa-solid fa-virus"></i> Data Penyakit
            </a>
            <a href="{{ route('kesehatan.informasi.index') }}" class="menu-item {{ request()->routeIs('kesehatan.informasi.*') ? 'active' : '' }}">
                <i class="fa-solid fa-bullhorn"></i> Informasi Terbaru
            </a>
            
            @if(Auth::user()->isSuperAdmin() || Auth::user()->isDivisionAdmin())
            <a href="{{ route('division.users.index', 'kesehatan') }}" class="menu-item {{ request()->routeIs('division.users.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users-gear"></i> Manajemen User
            </a>
            @endif
            <a href="{{ route('profile.index') }}" class="menu-item {{ request()->routeIs('profile.index') ? 'active' : '' }}">
                <i class="fa-solid fa-user-circle"></i> Profil
            </a>
@endsection
