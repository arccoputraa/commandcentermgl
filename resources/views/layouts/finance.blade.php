@extends('layouts.division_base')
@section('title', 'Dashboard')

@section('sidebar_menu')
<a href="{{ route('finance.dashboard') }}" class="menu-item {{ request()->routeIs('finance.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie"></i> Dashboard Keuangan
            </a>
            <a href="{{ route('finance.budget.index') }}" class="menu-item {{ request()->routeIs('finance.budget.*') ? 'active' : '' }}">
                <i class="fa-solid fa-wallet"></i> Data Anggaran & Realisasi
            </a>
            <a href="{{ route('finance.pad.index') }}" class="menu-item {{ request()->routeIs('finance.pad.*') ? 'active' : '' }}">
                <i class="fa-solid fa-coins"></i> Pendapatan Daerah / PAD
            </a>
            <a href="{{ route('finance.tax.index') }}" class="menu-item {{ request()->routeIs('finance.tax.*') ? 'active' : '' }}">
                <i class="fa-solid fa-receipt"></i> Data Pajak Daerah
            </a>
            <a href="{{ route('finance.subbidang.index') }}" class="menu-item {{ request()->routeIs('finance.subbidang.*') ? 'active' : '' }}">
                <i class="fa-solid fa-building-columns"></i> Sub Bidang / Unit Keuangan
            </a>
            <a href="{{ route('finance.information.index') }}" class="menu-item {{ request()->routeIs('finance.information.*') ? 'active' : '' }}">
                <i class="fa-solid fa-download"></i> Informasi Terbaru
            </a>
            
            @if(Auth::user()->isSuperAdmin() || Auth::user()->isDivisionAdmin())
            <a href="{{ route('division.users.index', 'finance') }}" class="menu-item {{ request()->routeIs('division.users.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users-gear"></i> Manajemen User
            </a>
            @endif
            <a href="{{ route('profile.index') }}" class="menu-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="fa-solid fa-user-circle"></i> Profil
            </a>
@endsection
