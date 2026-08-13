<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KesehatanPenyakit;

class KesehatanController extends Controller
{
    public function dashboard()
    {
        $totalProgram = 48;
        $pasienTerpantau = 12450;
        $kasusAktif = 324;
        $imunisasi = 85210;
        $vaksinasi = 120400;
        $pencegahanStunting = 1240;
        $kartuSehat = 32150;

        return view('kesehatan.dashboard', compact(
            'totalProgram', 'pasienTerpantau', 'kasusAktif', 'imunisasi', 
            'vaksinasi', 'pencegahanStunting', 'kartuSehat'
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
