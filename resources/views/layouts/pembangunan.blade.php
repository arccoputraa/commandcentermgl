@extends('layouts.division_base')
@section('title', 'Pusat Data Pembangunan')

@section('sidebar_menu')
<a href="{{ route('pembangunan.dashboard') }}" class="menu-item {{ request()->routeIs('pembangunan.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-building"></i> Dashboard Pembangunan
            </a>
            <a href="{{ route('pembangunan.project.index') }}" class="menu-item {{ request()->routeIs('pembangunan.project.*') ? 'active' : '' }}">
                <i class="fa-solid fa-folder-tree"></i> Data Proyek
            </a>
            <a href="{{ route('pembangunan.progress.index') }}" class="menu-item {{ request()->routeIs('pembangunan.progress.*') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-line"></i> Riwayat Progres
            </a>
            <a href="{{ route('pembangunan.document.index') }}" class="menu-item {{ request()->routeIs('pembangunan.document.*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-pdf"></i> Dokumen Proyek
            </a>
            
            @if(Auth::user()->isSuperAdmin() || Auth::user()->isDivisionAdmin())
            <a href="{{ route('division.users.index', 'pembangunan') }}" class="menu-item {{ request()->routeIs('division.users.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users-gear"></i> Manajemen User
            </a>
            @endif
            <a href="{{ route('profile.index') }}" class="menu-item {{ request()->routeIs('profile.index') ? 'active' : '' }}">
                <i class="fa-solid fa-user-circle"></i> Profil
            </a>
@endsection
