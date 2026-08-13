<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FinanceBudget;
use App\Models\FinancePad;
use Illuminate\Support\Facades\DB;

class KeuanganController extends Controller
{
    public function dashboard()
    {
        // 1. Hitung metrik keseluruhan
        $totalAnggaran = FinanceBudget::sum('total_anggaran');
        $totalRealisasiBelanja = FinanceBudget::sum('total_realisasi');
        $sisaAnggaran = $totalAnggaran - $totalRealisasiBelanja;

        $targetPAD = FinancePad::sum('target_pad');
        $realisasiPAD = FinancePad::sum('realisasi_pad');
        $persentaseRealisasiPAD = $targetPAD > 0 ? round(($realisasiPAD / $targetPAD) * 100, 1) : 0;
        
        $pajakDaerah = FinancePad::where('sumber_pendapatan', 'Pajak Daerah')->sum('realisasi_pad');

        // 2. Data untuk Chart (Realisasi Belanja per Sub Bidang)
        $chartBelanja = FinanceBudget::select('sub_bidang', DB::raw('SUM(total_realisasi) as total'))
            ->groupBy('sub_bidang')
            ->orderBy('total', 'desc')
            ->get();
            
        $labelBelanja = $chartBelanja->pluck('sub_bidang')->toArray();
        $dataBelanja = $chartBelanja->pluck('total')->toArray();

        // 3. Data untuk Chart (Realisasi PAD per Sumber Pendapatan)
        $chartPad = FinancePad::select('sumber_pendapatan', DB::raw('SUM(realisasi_pad) as total'))
            ->groupBy('sumber_pendapatan')
            ->orderBy('total', 'desc')
            ->get();
            
        $labelPad = $chartPad->pluck('sumber_pendapatan')->toArray();
        $dataPad = $chartPad->pluck('total')->toArray();

        // Pass ke view
        return view('finance.dashboard', compact(
            'totalAnggaran', 'totalRealisasiBelanja', 'sisaAnggaran', 
            'targetPAD', 'realisasiPAD', 'persentaseRealisasiPAD', 'pajakDaerah',
            'labelBelanja', 'dataBelanja', 'labelPad', 'dataPad'
        ));
    }
}
