<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PegawaiData;
use App\Models\PegawaiMutasi;
use App\Models\PegawaiInformasi;

class KepegawaianController extends Controller
{
    public function dashboard()
    {
        $totalPegawai = PegawaiData::count();
        $pegawaiAktif = PegawaiData::where('status_pegawai', 'Aktif')->count();
        
        $pnsCount = PegawaiData::where('jenis_pegawai', 'PNS')->count();
        $pppkCount = PegawaiData::where('jenis_pegawai', 'PPPK')->count();
        $nonAsnCount = PegawaiData::where('jenis_pegawai', 'Non-ASN')->count();

        // Mendekati Pensiun (example logic: age > 58, but we don't have DOB, so let's mock it or query mutasi pensiun this year)
        $mendekatiPensiun = PegawaiMutasi::where('jenis', 'Pensiun')
            ->whereYear('tanggal_efektif', date('Y'))->count();
            
        // Mutasi Tahun Ini
        $mutasiTahunIni = PegawaiMutasi::where('jenis', 'Mutasi')
            ->whereYear('tanggal_efektif', date('Y'))->count();

        $informasiTerbaru = PegawaiInformasi::orderBy('created_at', 'desc')->limit(5)->get();

        // Pegawai per Unit Kerja
        $pegawaiPerUnit = PegawaiData::select('unit_kerja', \DB::raw('count(*) as total'))
            ->whereNotNull('unit_kerja')
            ->groupBy('unit_kerja')
            ->get();
            
        // Max value for progress bar
        $maxPerUnit = $pegawaiPerUnit->max('total') ?: 1;

        return view('kepegawaian.dashboard', compact(
            'totalPegawai', 'pegawaiAktif', 'pnsCount', 'pppkCount', 'nonAsnCount', 
            'mendekatiPensiun', 'mutasiTahunIni', 'informasiTerbaru', 'pegawaiPerUnit', 'maxPerUnit'
        ));
    }
}
