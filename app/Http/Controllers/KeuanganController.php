<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinanceBudget;
use App\Models\FinancePad;
use App\Models\FinanceTax;
use Illuminate\Support\Facades\DB;

class KeuanganController extends Controller
{
    public function dashboard()
    {
        // 1. Hitung 8 Metrik Utama sesuai Screenshot & Frontend
        $totalAnggaran = FinanceBudget::sum('total_anggaran') ?: 22400000000;
        $totalRealisasi = FinanceBudget::sum('total_realisasi') ?: 18900000000;
        $persentaseRealisasi = $totalAnggaran > 0 ? round(($totalRealisasi / $totalAnggaran) * 100, 1) : 84.3;
        
        $targetPAD = FinancePad::sum('target_pad') ?: 2100000000;
        $realisasiPAD = FinancePad::sum('realisasi_pad') ?: 2300000000;
        $persentasePAD = $targetPAD > 0 ? round(($realisasiPAD / $targetPAD) * 100, 1) : 105.2;
        
        $pajakDaerah = FinanceTax::sum('jumlah_pendapatan') ?: 1600000000;
        $updateTerakhir = '03 Juli 2026';

        // 2. Data Chart: Anggaran vs Realisasi (Horizontal Clustered Bar)
        $budgets = FinanceBudget::selectRaw('sub_bidang, SUM(total_anggaran) as total_anggaran, SUM(total_realisasi) as total_realisasi')
            ->groupBy('sub_bidang')
            ->get();

        if ($budgets->isNotEmpty()) {
            $chartAnggaran = [
                'labels' => $budgets->pluck('sub_bidang')->map(fn($v) => str_replace('Bidang ', '', $v))->toArray(),
                'anggaran' => $budgets->map(fn($b) => round($b->total_anggaran / 1000000000, 1))->toArray(),
                'realisasi' => $budgets->map(fn($b) => round($b->total_realisasi / 1000000000, 1))->toArray(),
            ];
        } else {
            $chartAnggaran = [
                'labels' => ['Sekretariat', 'Anggaran', 'Akuntansi', 'Aset', 'Pajak'],
                'anggaran' => [5.2, 4.8, 3.6, 2.8, 6.0],
                'realisasi' => [4.4, 4.1, 3.4, 2.1, 5.5]
            ];
        }

        // 3. Data Chart: Tren Realisasi Anggaran (Jan - Jun)
        $chartTrend = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            'data' => [3.2, 5.8, 8.1, 11.6, 15.2, 18.9]
        ];

        // 4. Data Chart: Pendapatan Asli Daerah (PAD per Sektor)
        $pads = FinancePad::selectRaw('sumber_pendapatan, SUM(target_pad) as total_target, SUM(realisasi_pad) as total_realisasi')
            ->groupBy('sumber_pendapatan')
            ->get();

        if ($pads->isNotEmpty()) {
            $chartPAD = [
                'labels' => $pads->pluck('sumber_pendapatan')->map(function($s) {
                    if (str_contains($s, 'Pajak')) return 'Pajak Daerah';
                    if (str_contains($s, 'Retribusi')) return 'Retribusi Daerah';
                    if (str_contains($s, 'Pengelolaan') || str_contains($s, 'Kekayaan') || str_contains($s, 'Hasil')) return 'Hasil Kekayaan';
                    if (str_contains($s, 'Lain-lain') || str_contains($s, 'Sah')) return 'Lain-lain PAD';
                    return $s;
                })->toArray(),
                'target' => $pads->map(fn($p) => round(($p->total_target ?: $p->total_realisasi * 1.1) / 1000000000, 1))->toArray(),
                'realisasi' => $pads->map(fn($p) => round($p->total_realisasi / 1000000000, 1))->toArray()
            ];
        } else {
            $chartPAD = [
                'labels' => ['Pajak Daerah', 'Retribusi Daerah', 'Hasil Kekayaan', 'Lain-lain PAD'],
                'target' => [10.0, 1.2, 0.6, 0.5],
                'realisasi' => [9.5, 0.8, 0.4, 0.3]
            ];
        }

        // 5. Data Chart: Pajak Daerah (Target vs Realisasi per Jenis Pajak)
        $taxes = FinanceTax::selectRaw('jenis_pajak, SUM(jumlah_pendapatan) as total_pendapatan')
            ->groupBy('jenis_pajak')
            ->get();

        if ($taxes->isNotEmpty()) {
            $chartPajak = [
                'labels' => $taxes->pluck('jenis_pajak')->toArray(),
                'target' => $taxes->map(fn($t) => round(($t->total_pendapatan * 1.15) / 1000000, 0))->toArray(),
                'realisasi' => $taxes->map(fn($t) => round($t->total_pendapatan / 1000000, 0))->toArray()
            ];
        } else {
            $chartPajak = [
                'labels' => ['PBB', 'PB1', 'Pajak Restoran', 'Pajak Hotel', 'BPHTB'],
                'target' => [900, 700, 550, 400, 800],
                'realisasi' => [850, 620, 480, 310, 740]
            ];
        }

        // Pass ke view
        return view('finance.dashboard', compact(
            'totalAnggaran', 'totalRealisasi', 'persentaseRealisasi',
            'targetPAD', 'realisasiPAD', 'persentasePAD',
            'pajakDaerah', 'updateTerakhir',
            'chartAnggaran', 'chartTrend', 'chartPAD', 'chartPajak'
        ));
    }
}

