<?php

namespace App\Http\Controllers;

use App\Models\PegawaiMutasi;
use App\Models\PegawaiData;
use Illuminate\Http\Request;

class PegawaiMutasiController extends Controller
{
    public function index(Request $request)
    {
        $query = PegawaiMutasi::query();
        
        $tab = $request->get('tab', 'mutasi');

        if ($tab == 'pensiun') {
            $query->where('jenis', 'Pensiun');
        } else {
            $query->where('jenis', '!=', 'Pensiun');
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_pegawai', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('jenis', 'like', "%{$search}%");
            });
        }
        
        $mutasis = $query->orderBy('created_at', 'desc')->get();
        // Mendapatkan data pegawai untuk dropdown modal
        $pegawais = PegawaiData::all();
        
        return view('kepegawaian.mutasi.index', compact('mutasis', 'pegawais', 'tab'));
    }

    public function create()
    {
        return view('kepegawaian.mutasi.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|string',
            'jenis' => 'required|string',
            'tanggal_efektif' => 'required|date',
            'status_pengajuan' => 'required|string',
            'keterangan' => 'nullable|string'
        ]);

        // Cari nama pegawai berdasarkan nip
        $pegawai = PegawaiData::where('nip', $request->nip)->first();
        $namaPegawai = $pegawai ? $pegawai->nama : 'Unknown';

        PegawaiMutasi::create([
            'nip' => $request->nip,
            'nama_pegawai' => $namaPegawai,
            'jenis' => $request->jenis,
            'tanggal_efektif' => $request->tanggal_efektif,
            'status_pengajuan' => $request->status_pengajuan,
            'keterangan' => $request->keterangan
        ]);

        return redirect()->route('kepegawaian.mutasi.index')->with('success', 'Data mutasi/pensiun berhasil ditambahkan.');
    }

    public function show($id)
    {
        $mutasi = PegawaiMutasi::findOrFail($id);
        return view('kepegawaian.mutasi.detail', compact('mutasi'));
    }

    public function edit($id)
    {
        $mutasi = PegawaiMutasi::findOrFail($id);
        return view('kepegawaian.mutasi.form', compact('mutasi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nip' => 'required|string',
            'jenis' => 'required|string',
            'tanggal_efektif' => 'required|date',
            'status_pengajuan' => 'required|string',
            'keterangan' => 'nullable|string'
        ]);

        $mutasi = PegawaiMutasi::findOrFail($id);
        
        $pegawai = PegawaiData::where('nip', $request->nip)->first();
        $namaPegawai = $pegawai ? $pegawai->nama : $mutasi->nama_pegawai;

        $mutasi->update([
            'nip' => $request->nip,
            'nama_pegawai' => $namaPegawai,
            'jenis' => $request->jenis,
            'tanggal_efektif' => $request->tanggal_efektif,
            'status_pengajuan' => $request->status_pengajuan,
            'keterangan' => $request->keterangan
        ]);

        return redirect()->route('kepegawaian.mutasi.index')->with('success', 'Data mutasi/pensiun berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $mutasi = PegawaiMutasi::findOrFail($id);
        $mutasi->delete();

        return redirect()->route('kepegawaian.mutasi.index')->with('success', 'Data mutasi/pensiun berhasil dihapus.');
    }
}
