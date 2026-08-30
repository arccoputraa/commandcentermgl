<?php

namespace App\Http\Controllers;

use App\Models\PegawaiData;
use Illuminate\Http\Request;

class PegawaiDataController extends Controller
{
    public function index(Request $request)
    {
        $query = PegawaiData::query();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%");
            });
        }
        
        $pegawais = $query->orderBy('created_at', 'desc')->get();
        return view('kepegawaian.data.index', compact('pegawais'));
    }

    public function create()
    {
        return view('kepegawaian.data.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|string|unique:pegawai_data',
            'nama' => 'required|string',
            'jenis_pegawai' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'jabatan' => 'nullable|string',
            'golongan' => 'nullable|string',
            'unit_kerja' => 'nullable|string',
            'status_pegawai' => 'required|string',
            'tanggal_bergabung' => 'nullable|date'
        ]);

        PegawaiData::create($request->all());

        return redirect()->route('kepegawaian.data.index')->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    public function show($id)
    {
        $pegawai = PegawaiData::findOrFail($id);
        return view('kepegawaian.data.detail', compact('pegawai'));
    }

    public function edit($id)
    {
        $pegawai = PegawaiData::findOrFail($id);
        return view('kepegawaian.data.form', compact('pegawai'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nip' => 'required|string|unique:pegawai_data,nip,'.$id,
            'nama' => 'required|string',
            'jenis_pegawai' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'jabatan' => 'nullable|string',
            'golongan' => 'nullable|string',
            'unit_kerja' => 'nullable|string',
            'status_pegawai' => 'required|string',
            'tanggal_bergabung' => 'nullable|date'
        ]);

        $pegawai = PegawaiData::findOrFail($id);
        $pegawai->update($request->all());

        return redirect()->route('kepegawaian.data.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pegawai = PegawaiData::findOrFail($id);
        $pegawai->delete();

        return redirect()->route('kepegawaian.data.index')->with('success', 'Data pegawai berhasil dihapus.');
    }
}
