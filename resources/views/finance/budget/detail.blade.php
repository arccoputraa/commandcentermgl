@extends('layouts.finance')

@section('title', 'Detail Data Anggaran & Realisasi')

@section('content')
<style>
    .finance-header {
        margin-bottom: 24px;
        font-family: 'Inter', sans-serif;
    }
    .breadcrumb {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 8px;
    }
    .breadcrumb a {
        color: #3b82f6;
        text-decoration: none;
    }
    .breadcrumb a:hover {
        text-decoration: underline;
    }
    .header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .header-text h2 {
        font-size: 22px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }
    .btn-group {
        display: flex;
        gap: 12px;
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
        gap: 8px;
        transition: all 0.2s;
    }
    .btn-outline:hover {
        background: #f1f5f9;
        color: #0f172a;
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
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background 0.2s;
    }
    .btn-primary:hover {
        background: #1d4ed8;
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
        margin-bottom: 40px;
    }
    
    .detail-item {
        margin-bottom: 24px;
    }
    .detail-item:last-child {
        margin-bottom: 0;
    }
    .detail-label {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 6px;
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
    .badge-berjalan {
        background: #eff6ff;
        color: #3b82f6;
        border: 1px solid #bfdbfe;
    }
    .badge-hampir-tercapai {
        background: #eff6ff;
        color: #3b82f6;
        border: 1px solid #bfdbfe;
    }
    .badge-perlu-perhatian {
        background: #fefce8;
        color: #ca8a04;
        border: 1px solid #fef08a;
    }
    
    .riwayat-section {
        border-top: 1px solid #e2e8f0;
        padding-top: 24px;
    }
    .riwayat-title {
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 12px;
    }
    .riwayat-text {
        font-size: 14px;
        color: #64748b;
    }
</style>

<div class="finance-header">
    <div class="breadcrumb">
        <a href="{{ route('finance.dashboard') }}">Dashboard Keuangan</a> / 
        <a href="{{ route('finance.budget.index') }}">Data Anggaran & Realisasi</a> / 
        Detail
    </div>
    <div class="header-actions">
        <div class="header-text">
            <h2>Detail Data Anggaran & Realisasi</h2>
        </div>
        <div class="btn-group">
            <a href="{{ route('finance.budget.index') }}" class="btn-outline">Kembali</a>
            <button class="btn-primary" onclick="alert('Fitur edit dari halaman detail akan diarahkan ke modal halaman list, atau silakan kembali ke halaman list.')">
                <i class="fa-solid fa-pen-to-square"></i> Edit Data
            </button>
        </div>
    </div>
</div>

<div class="detail-card">
    @php
        $persentase = $budget->total_anggaran > 0 ? round(($budget->total_realisasi / $budget->total_anggaran) * 100) : 0;
        $badgeClass = 'badge-berjalan';
        if (str_contains(strtolower($budget->status), 'hampir tercapai')) {
            $badgeClass = 'badge-hampir-tercapai';
        } elseif (str_contains(strtolower($budget->status), 'perlu perhatian')) {
            $badgeClass = 'badge-perlu-perhatian';
        }
    @endphp
    <div class="detail-grid">
        <!-- Kolom Kiri -->
        <div>
            <div class="detail-item">
                <div class="detail-label">Tahun</div>
                <div class="detail-value">{{ $budget->tahun }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Nama Anggaran</div>
                <div class="detail-value">{{ $budget->nama_anggaran }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Total Realisasi</div>
                <div class="detail-value">Rp{{ number_format($budget->total_realisasi, 0, ',', '.') }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Periode</div>
                <div class="detail-value">{{ $budget->periode ?: '-' }}</div>
            </div>
            @if($budget->catatan_internal)
            <div class="detail-item">
                <div class="detail-label">Catatan Internal</div>
                <div class="detail-value" style="font-weight: 400;">{{ $budget->catatan_internal }}</div>
            </div>
            @endif
        </div>
        
        <!-- Kolom Kanan -->
        <div>
            <div class="detail-item">
                <div class="detail-label">Sub Bidang / Unit</div>
                <div class="detail-value">{{ $budget->sub_bidang }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Total Anggaran</div>
                <div class="detail-value">Rp{{ number_format($budget->total_anggaran, 0, ',', '.') }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Persentase</div>
                <div class="detail-value">{{ $persentase }}%</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Keterangan</div>
                <div class="detail-value">
                    <span class="badge-status {{ $badgeClass }}">
                        {{ $budget->status ?? 'Berjalan' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="riwayat-section">
        <div class="riwayat-title">Riwayat Update</div>
        <div class="riwayat-text">
            Dibuat pada • {{ $budget->created_at->format('d M Y H:i') }} 
            @if($budget->updated_at != $budget->created_at)
                - Diperbarui pada • {{ $budget->updated_at->format('d M Y H:i') }}
            @endif
        </div>
    </div>
</div>

@endsection
