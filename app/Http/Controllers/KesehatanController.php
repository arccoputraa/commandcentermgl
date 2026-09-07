<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KesehatanPenyakit;

class KesehatanController extends Controller
{
    public function dashboard()
    {
        $totalProgram        = \App\Models\KesehatanInformasi::count();
        $pasienTerpantau     = \App\Models\KesehatanPenyakit::sum('jumlah');
        $kasusAktif          = \App\Models\KesehatanPenyakit::where('status', 'Aktif')->sum('jumlah') ?: 324;
        $vaksinasi           = 85210;
        $pencegahanStunting  = 1240;
        $kartuSehat          = 32150;

        // Tren Pasien Per Bulan
        $bulanList = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        $trenBulanan = array_fill(0, 12, 0);
        $penyakitBulanan = \App\Models\KesehatanPenyakit::selectRaw('bulan, SUM(jumlah) as total')
            ->groupBy('bulan')->get();
        foreach ($penyakitBulanan as $row) {
            $idx = array_search($row->bulan, $bulanList);
            if ($idx !== false) {
                $trenBulanan[$idx] = (int) $row->total;
            }
        }

        // Kasus per wilayah (untuk donut chart)
        $kasusWilayah = \App\Models\KesehatanPenyakit::selectRaw('wilayah, SUM(jumlah) as total')
            ->groupBy('wilayah')->orderByDesc('total')->limit(4)->get();

        // Top 5 penyakit
        $topPenyakit = \App\Models\KesehatanPenyakit::orderBy('jumlah', 'desc')->limit(5)->get();

        // Informasi terbaru
        $informasi = \App\Models\KesehatanInformasi::orderBy('created_at', 'desc')->limit(5)->get();

        return view('kesehatan.dashboard', compact(
            'totalProgram', 'pasienTerpantau', 'kasusAktif',
            'vaksinasi', 'pencegahanStunting', 'kartuSehat',
            'bulanList', 'trenBulanan', 'kasusWilayah', 'topPenyakit', 'informasi'
        ));
    }

    public function programIndex()
    {
        return view('kesehatan.program.index');
    }

    public function programDetail($id)
    {
        return view('kesehatan.program.detail', compact('id'));
    }

    public function penyakitIndex()
    {
        $data = KesehatanPenyakit::orderBy('id', 'desc')->get();
        return view('kesehatan.penyakit.index', compact('data'));
    }

    public function penyakitStore(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'jumlah' => 'required|integer',
            'tahun' => 'required|integer',
            'bulan' => 'required|string',
            'wilayah' => 'required|string',
            'status' => 'required|string',
        ]);

        KesehatanPenyakit::create($validated);
        return back()->with('success', 'Data berhasil ditambahkan');
    }

    public function penyakitUpdate(Request $request, $id)
    {
        $penyakit = KesehatanPenyakit::findOrFail($id);
        
        $validated = $request->validate([
            'nama' => 'required|string',
            'jumlah' => 'required|integer',
            'tahun' => 'required|integer',
            'bulan' => 'required|string',
            'wilayah' => 'required|string',
            'status' => 'required|string',
        ]);

        $penyakit->update($validated);
        return back()->with('success', 'Data berhasil diubah');
    }

    public function penyakitDestroy($id)
    {
        $penyakit = KesehatanPenyakit::findOrFail($id);
        $penyakit->delete();
        
        return back()->with('success', 'Data berhasil dihapus');
    }

    public function penyakitDetail($id)
    {
        $penyakit = KesehatanPenyakit::findOrFail($id);
        return view('kesehatan.penyakit.detail', compact('penyakit'));
    }
}
