<?php

namespace App\Http\Controllers;

use App\Models\PegawaiInformasi;
use Illuminate\Http\Request;

class PegawaiInformasiController extends Controller
{
    public function index(Request $request)
    {
        $query = PegawaiInformasi::query();
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
        }
        
        $informasis = $query->orderBy('created_at', 'desc')->get();
        return view('kepegawaian.informasi.index', compact('informasis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'kategori' => 'required|string',
            'format' => 'nullable|string',
            'dokumen' => 'nullable|string',
            'status_publikasi' => 'required|string',
            'keterangan' => 'nullable|string'
        ]);

        PegawaiInformasi::create($request->all());

        return redirect()->route('kepegawaian.informasi.index')->with('success', 'Informasi berhasil ditambahkan.');
    }

    public function show($id)
    {
        $informasi = PegawaiInformasi::findOrFail($id);
        return view('kepegawaian.informasi.detail', compact('informasi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string',
            'kategori' => 'required|string',
            'format' => 'nullable|string',
            'dokumen' => 'nullable|string',
            'status_publikasi' => 'required|string',
            'keterangan' => 'nullable|string'
        ]);

        $informasi = PegawaiInformasi::findOrFail($id);
        $informasi->update($request->all());

        return redirect()->route('kepegawaian.informasi.index')->with('success', 'Informasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $informasi = PegawaiInformasi::findOrFail($id);
        $informasi->delete();

        return redirect()->route('kepegawaian.informasi.index')->with('success', 'Informasi berhasil dihapus.');
    }
}
