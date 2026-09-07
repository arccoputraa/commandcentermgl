<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KesehatanPenyakit;

class KesehatanController extends Controller
{
    public function dashboard()
    {
        $totalProgram        = 48;
        $pasienTerpantau     = 12450;
        $kasusAktif          = 324;
        $imunisasi           = 85210;
        $vaksinasi           = 120400;
        $pencegahanStunting  = 1240;
        $kartuSehat          = 32150;
        $updateTerakhir      = 'Hari Ini';

        $programUtama = [
            [
                'judul' => 'Pencegahan Stunting',
                'status' => 'Aktif',
                'badge_class' => 'bg-emerald-100 text-emerald-600',
                'jumlah' => '1,240 Data',
                'persentase' => 65,
                'bar_color' => '#f59e0b',
                'route' => route('kesehatan.program.index'),
            ],
            [
                'judul' => 'Vaksin Covid-19',
                'status' => 'Aktif',
                'badge_class' => 'bg-emerald-100 text-emerald-600',
                'jumlah' => '120,400 Dosis',
                'persentase' => 85,
                'bar_color' => '#3b82f6',
                'route' => route('kesehatan.program.index'),
            ],
            [
                'judul' => 'Imunisasi Balita',
                'status' => 'Selesai',
                'badge_class' => 'bg-slate-100 text-slate-600',
                'jumlah' => '85,210 Anak',
                'persentase' => 100,
                'bar_color' => '#10b981',
                'route' => route('kesehatan.program.index'),
            ],
            [
                'judul' => 'Distribusi Kartu Sehat',
                'status' => 'Aktif',
                'badge_class' => 'bg-emerald-100 text-emerald-600',
                'jumlah' => '32,150 KK',
                'persentase' => 45,
                'bar_color' => '#a855f7',
                'route' => route('kesehatan.program.index'),
            ],
        ];

        return view('kesehatan.dashboard', compact(
            'totalProgram', 'pasienTerpantau', 'kasusAktif', 'imunisasi',
            'vaksinasi', 'pencegahanStunting', 'kartuSehat', 'updateTerakhir',
            'programUtama'
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
