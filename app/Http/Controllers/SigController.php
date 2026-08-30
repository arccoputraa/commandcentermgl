<?php

namespace App\Http\Controllers;

use App\Models\LayerSig;
use App\Models\DataSpasial;
use App\Models\DokumenSig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SigController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_layer' => LayerSig::count(),
            'layer_aktif' => LayerSig::where('status_aktif', true)->count(),
            'total_data' => DataSpasial::count(),
        ];
        
        $dokumen = DokumenSig::orderBy('tanggal_rilis', 'desc')->limit(5)->get();

        return view('sig.dashboard', compact('stats', 'dokumen'));
    }

    // Layer SIG CRUD
    public function layerIndex()
    {
        $layers = LayerSig::orderBy('nama_layer')->get();
        return view('sig.layer.index', compact('layers'));
    }

    public function layerStore(Request $request)
    {
        $validated = $request->validate([
            'nama_layer' => 'required|string|max:255',
            'status_aktif' => 'boolean',
        ]);

        $validated['status_aktif'] = $request->has('status_aktif');
        LayerSig::create($validated);
        
        return redirect()->route('sig.layer.index')->with('success', 'Layer berhasil ditambahkan.');
    }

    public function layerUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_layer' => 'required|string|max:255',
            'status_aktif' => 'boolean',
        ]);

        $layer = LayerSig::findOrFail($id);
        $validated['status_aktif'] = $request->has('status_aktif');
        $layer->update($validated);
        
        return redirect()->route('sig.layer.index')->with('success', 'Layer berhasil diperbarui.');
    }

    public function layerDestroy($id)
    {
        $layer = LayerSig::findOrFail($id);
        $layer->delete();
        return redirect()->route('sig.layer.index')->with('success', 'Layer berhasil dihapus.');
    }

    // Data Spasial CRUD
    public function dataSpasialIndex()
    {
        $dataSpasial = DataSpasial::with('layer')->orderBy('nama_data')->get();
        $layers = LayerSig::where('status_aktif', true)->get();
        return view('sig.data_spasial.index', compact('dataSpasial', 'layers'));
    }

    public function dataSpasialStore(Request $request)
    {
        $validated = $request->validate([
            'layer_id' => 'required|exists:layer_sig,id',
            'nama_data' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'wilayah' => 'required|string|max:255',
            'nilai_jumlah' => 'required|integer',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        DataSpasial::create($validated);
        return redirect()->route('sig.data-spasial.index')->with('success', 'Data Spasial berhasil ditambahkan.');
    }

    public function dataSpasialUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'layer_id' => 'required|exists:layer_sig,id',
            'nama_data' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'wilayah' => 'required|string|max:255',
            'nilai_jumlah' => 'required|integer',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $data = DataSpasial::findOrFail($id);
        $data->update($validated);
        
        return redirect()->route('sig.data-spasial.index')->with('success', 'Data Spasial berhasil diperbarui.');
    }

    public function dataSpasialDestroy($id)
    {
        $data = DataSpasial::findOrFail($id);
        $data->delete();
        return redirect()->route('sig.data-spasial.index')->with('success', 'Data Spasial berhasil dihapus.');
    }

    // Dokumen SIG CRUD
    public function dokumenIndex()
    {
        $dokumen = DokumenSig::orderBy('tanggal_rilis', 'desc')->get();
        return view('sig.dokumen.index', compact('dokumen'));
    }

    public function dokumenStore(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'file_dokumen' => 'required|mimes:pdf|max:10240',
            'status_tag' => 'required|string|max:255',
            'tanggal_rilis' => 'required|date',
        ]);

        $path = $request->file('file_dokumen')->store('dokumen_sig', 'public');

        DokumenSig::create([
            'judul' => $validated['judul'],
            'file_path' => $path,
            'status_tag' => $validated['status_tag'],
            'tanggal_rilis' => $validated['tanggal_rilis'],
        ]);

        return redirect()->route('sig.dokumen.index')->with('success', 'Dokumen SIG berhasil diunggah.');
    }

    public function dokumenUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'file_dokumen' => 'nullable|mimes:pdf|max:10240',
            'status_tag' => 'required|string|max:255',
            'tanggal_rilis' => 'required|date',
        ]);

        $dokumen = DokumenSig::findOrFail($id);

        if ($request->hasFile('file_dokumen')) {
            if ($dokumen->file_path && Storage::disk('public')->exists($dokumen->file_path)) {
                Storage::disk('public')->delete($dokumen->file_path);
            }
            $path = $request->file('file_dokumen')->store('dokumen_sig', 'public');
            $dokumen->file_path = $path;
        }

        $dokumen->judul = $validated['judul'];
        $dokumen->status_tag = $validated['status_tag'];
        $dokumen->tanggal_rilis = $validated['tanggal_rilis'];
        $dokumen->save();

        return redirect()->route('sig.dokumen.index')->with('success', 'Dokumen SIG berhasil diperbarui.');
    }

    public function dokumenDestroy($id)
    {
        $dokumen = DokumenSig::findOrFail($id);
        
        if ($dokumen->file_path && Storage::disk('public')->exists($dokumen->file_path)) {
            Storage::disk('public')->delete($dokumen->file_path);
        }
        
        $dokumen->delete();
        return redirect()->route('sig.dokumen.index')->with('success', 'Dokumen SIG berhasil dihapus.');
    }
}
