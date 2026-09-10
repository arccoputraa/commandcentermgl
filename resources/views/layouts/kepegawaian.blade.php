@extends('layouts.division_base')
@section('title', 'Dashboard Kepegawaian')

@section('sidebar_menu')
<a href="{{ route('kepegawaian.dashboard') }}" class="menu-item {{ request()->routeIs('kepegawaian.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-border-all"></i> Dashboard Kepegawaian
            </a>
            <a href="{{ route('kepegawaian.data.index') }}" class="menu-item {{ request()->routeIs('kepegawaian.data.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i> Data Pegawai
            </a>
            <a href="{{ route('kepegawaian.jabatan.index') }}" class="menu-item {{ request()->routeIs('kepegawaian.jabatan.*') ? 'active' : '' }}">
                <i class="fa-solid fa-building-user"></i> Jabatan & Unit Kerja
            </a>
            <a href="{{ route('kepegawaian.mutasi.index') }}" class="menu-item {{ request()->routeIs('kepegawaian.mutasi.*') ? 'active' : '' }}">
                <i class="fa-solid fa-people-arrows"></i> Mutasi & Pensiun
            </a>
            <a href="{{ route('kepegawaian.informasi.index') }}" class="menu-item {{ request()->routeIs('kepegawaian.informasi.*') ? 'active' : '' }}">
                <i class="fa-solid fa-bullhorn"></i> Informasi Terbaru
            </a>
            
            @if(Auth::user()->isSuperAdmin() || Auth::user()->isDivisionAdmin())
            <a href="{{ route('division.users.index', 'kepegawaian') }}" class="menu-item {{ request()->routeIs('division.users.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users-gear"></i> Manajemen User
            </a>
            @endif
            <a href="{{ route('profile.index') }}" class="menu-item {{ request()->routeIs('profile.index') ? 'active' : '' }}">
                <i class="fa-regular fa-circle-user"></i> Profil
            </a>
@endsection
