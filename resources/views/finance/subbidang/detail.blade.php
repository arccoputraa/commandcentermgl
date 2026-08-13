@extends('layouts.finance')

@section('title', 'Detail Sub Bidang / Unit Keuangan')

@section('content')
<style>
    .breadcrumb {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 16px;
        font-family: 'Inter', sans-serif;
    }
    .breadcrumb a {
        color: #3b82f6;
        text-decoration: none;
    }
    .breadcrumb a:hover {
        text-decoration: underline;
    }

    .finance-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        font-family: 'Inter', sans-serif;
    }
    .header-text h2 {
        font-size: 24px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }
    
    .header-actions {
        display: flex;
        gap: 12px;
    }
    
    .btn-primary {
        background: #2563eb;
        color: #ffffff;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }
    .btn-primary:hover {
        background: #1d4ed8;
    }
    .btn-outline {
        background: transparent;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }
    .btn-outline:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    .detail-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        padding: 32px;
        font-family: 'Inter', sans-serif;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 32px;
    }

    .detail-item {
        margin-bottom: 24px;
    }
    .detail-label {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 8px;
        font-weight: 500;
    }
    .detail-value {
        font-size: 16px;
        color: #0f172a;
        font-weight: 600;
    }

    .badge-status {
        display: inline-flex;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    .badge-aktif {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }
    .badge-nonaktif {
        background: #fef2f2;
        color: #ef4444;
        border: 1px solid #fecaca;
    }

    .history-section {
        margin-top: 40px;
        padding-top: 24px;
        border-top: 1px solid #e2e8f0;
    }
    .history-title {
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 12px;
    }
    .history-text {
        font-size: 13px;
        color: #64748b;
    }
</style>

@php
    $badgeClass = strtolower($subbidang->status) == 'aktif' ? 'badge-aktif' : 'badge-nonaktif';
@endphp

<div class="breadcrumb">
    <a href="{{ route('finance.dashboard') }}">Dashboard Keuangan</a> / 
    <a href="{{ route('finance.subbidang.index') }}">Sub Bidang / Unit Keuangan</a> / 
    Detail
</div>

<div class="finance-header">
    <div class="header-text">
        <h2>Detail Sub Bidang / Unit Keuangan</h2>
    </div>
    <div class="header-actions">
        <a href="{{ route('finance.subbidang.index') }}" class="btn-outline">Kembali</a>
        <a href="{{ route('finance.subbidang.index') }}" class="btn-primary"><i class="fa-solid fa-pen-to-square"></i> Edit Data</a>
    </div>
</div>

<div class="detail-card">
    <div class="detail-grid">
        <!-- Kolom Kiri -->
        <div>
            <div class="detail-item">
                <div class="detail-label">Nama Sub Bidang / Unit</div>
                <div class="detail-value">{{ $subbidang->nama_unit }}</div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Deskripsi</div>
                <div class="detail-value">{{ $subbidang->deskripsi ?: '-' }}</div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Jumlah Staff/Pegawai</div>
                <div class="detail-value">{{ $subbidang->jumlah_staff }} Guru/Staff</div>
            </div>
        </div>
        
        <!-- Kolom Kanan -->
        <div>
            <div class="detail-item">
                <div class="detail-label">Kode Unit</div>
                <div class="detail-value">{{ $subbidang->kode_unit }}</div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Status</div>
                <div class="detail-value">
                    <span class="badge-status {{ $badgeClass }}">
                        {{ $subbidang->status }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="history-section">
        <div class="history-title">Riwayat Update</div>
        <div class="history-text">
            Data dibuat - {{ $subbidang->created_at->format('d M Y H:i') }} <br>
            Diperbarui - {{ $subbidang->updated_at->diffForHumans() }}
        </div>
    </div>
</div>

@endsection
