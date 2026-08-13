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

    public function create()
    {
        return view('kepegawaian.informasi.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'kategori' => 'required|string',
            'format' => 'nullable|string',
            'dokumen' => 'nullable|file|mimes:pdf|max:10240',
            'status_publikasi' => 'required|string',
            'keterangan' => 'nullable|string'
        ]);

        $data = $request->all();

        if ($request->hasFile('dokumen')) {
            $data['dokumen'] = $request->file('dokumen')->store('kepegawaian/informasi', 'public');
        }

        PegawaiInformasi::create($data);

        return redirect()->route('kepegawaian.informasi.index')->with('success', 'Informasi berhasil ditambahkan.');
    }

    public function show($id)
    {
        $informasi = PegawaiInformasi::findOrFail($id);
        return view('kepegawaian.informasi.detail', compact('informasi'));
    }

    public function edit($id)
    {
        $informasi = PegawaiInformasi::findOrFail($id);
        return view('kepegawaian.informasi.form', compact('informasi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string',
            'kategori' => 'required|string',
            'format' => 'nullable|string',
            'dokumen' => 'nullable|file|mimes:pdf|max:10240',
            'status_publikasi' => 'required|string',
            'keterangan' => 'nullable|string'
        ]);

        $informasi = PegawaiInformasi::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('dokumen')) {
            $data['dokumen'] = $request->file('dokumen')->store('kepegawaian/informasi', 'public');
        }

        $informasi->update($data);

        return redirect()->route('kepegawaian.informasi.index')->with('success', 'Informasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $informasi = PegawaiInformasi::findOrFail($id);
        $informasi->delete();

        return redirect()->route('kepegawaian.informasi.index')->with('success', 'Informasi berhasil dihapus.');
    }
}
