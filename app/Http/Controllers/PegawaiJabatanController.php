<?php

namespace App\Http\Controllers;

use App\Models\PegawaiJabatan;
use Illuminate\Http\Request;

class PegawaiJabatanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $jabatans = PegawaiJabatan::when($search, function($query) use ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('nama_jabatan', 'like', "%{$search}%")
                  ->orWhere('kode_unit', 'like', "%{$search}%");
            });
        })->get();

        $totalUnit = PegawaiJabatan::count();
        // Since we are showing "126 Pegawai", let's sum 'jumlah_pegawai' from jabatans or from PegawaiData
        $totalPegawai = \App\Models\PegawaiData::count();
        $unitAktif = PegawaiJabatan::where('status', 'Aktif')->count();

        return view('kepegawaian.jabatan.index', compact('jabatans', 'totalUnit', 'totalPegawai', 'unitAktif'));
    }

    public function create()
    {
        return view('kepegawaian.jabatan.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jabatan' => 'required|string',
            'kode_unit' => 'required|string',
            'jabatan_utama' => 'nullable|string',
            'deskripsi_unit' => 'nullable|string',
            'jumlah_pegawai' => 'nullable|integer',
            'status' => 'required|string'
        ]);

        PegawaiJabatan::create($request->all());

        return redirect()->route('kepegawaian.jabatan.index')->with('success', 'Data unit berhasil ditambahkan.');
    }

    public function show($id)
    {
        $jabatan = PegawaiJabatan::findOrFail($id);
        
        $pegawais = \App\Models\PegawaiData::where('unit_kerja', $jabatan->nama_jabatan)->get();
        $pns = $pegawais->where('jenis_pegawai', 'PNS')->count();
        $pppk = $pegawais->where('jenis_pegawai', 'PPPK')->count();
        $non_asn = $pegawais->where('jenis_pegawai', 'Non-ASN')->count();

        return view('kepegawaian.jabatan.detail', compact('jabatan', 'pegawais', 'pns', 'pppk', 'non_asn'));
    }

    public function edit($id)
    {
        $jabatan = PegawaiJabatan::findOrFail($id);
        return view('kepegawaian.jabatan.form', compact('jabatan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jabatan' => 'required|string',
            'kode_unit' => 'required|string',
            'jabatan_utama' => 'nullable|string',
            'deskripsi_unit' => 'nullable|string',
            'jumlah_pegawai' => 'nullable|integer',
            'status' => 'required|string'
        ]);

        $jabatan = PegawaiJabatan::findOrFail($id);
        $jabatan->update($request->all());

        return redirect()->route('kepegawaian.jabatan.index')->with('success', 'Data unit berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jabatan = PegawaiJabatan::findOrFail($id);
        $jabatan->delete();

        return redirect()->route('kepegawaian.jabatan.index')->with('success', 'Data jabatan berhasil dihapus.');
    }
}
