<?php

namespace App\Http\Controllers;

use App\Models\UjiKir;
use App\Models\DokumenPerhubungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PerhubunganController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_uji' => UjiKir::count(),
            'lulus_uji' => UjiKir::where('status_uji', 'Lulus Uji')->count(),
            'tidak_lulus' => UjiKir::where('status_uji', 'Tidak Lulus')->count(),
            'perlu_uji_ulang' => UjiKir::where('status_uji', 'Perlu Uji Ulang')->count(),
        ];
        
        $dokumen = DokumenPerhubungan::orderBy('tanggal_rilis', 'desc')->limit(5)->get();

        return view('perhubungan.dashboard', compact('stats', 'dokumen'));
    }

    // Uji KIR CRUD
    public function ujiKirIndex()
    {
        $ujiKir = UjiKir::orderBy('tanggal_uji', 'desc')->get();
        return view('perhubungan.ujikir.index', compact('ujiKir'));
    }

    public function ujiKirStore(Request $request)
    {
        $validated = $request->validate([
            'tanggal_uji' => 'required|date',
            'jenis_kendaraan' => 'required|string|max:255',
            'status_uji' => 'required|in:Lulus Uji,Tidak Lulus,Perlu Uji Ulang',
            'unit_layanan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        UjiKir::create($validated);
        return redirect()->route('perhubungan.ujikir.index')->with('success', 'Data Uji KIR berhasil ditambahkan.');
    }

    public function ujiKirUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'tanggal_uji' => 'required|date',
            'jenis_kendaraan' => 'required|string|max:255',
            'status_uji' => 'required|in:Lulus Uji,Tidak Lulus,Perlu Uji Ulang',
            'unit_layanan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $ujiKir = UjiKir::findOrFail($id);
        $ujiKir->update($validated);
        return redirect()->route('perhubungan.ujikir.index')->with('success', 'Data Uji KIR berhasil diperbarui.');
    }

    public function ujiKirDestroy($id)
    {
        $ujiKir = UjiKir::findOrFail($id);
        $ujiKir->delete();
        return redirect()->route('perhubungan.ujikir.index')->with('success', 'Data Uji KIR berhasil dihapus.');
    }

    // Dokumen Perhubungan CRUD
    public function dokumenIndex()
    {
        $dokumen = DokumenPerhubungan::orderBy('tanggal_rilis', 'desc')->get();
        return view('perhubungan.dokumen.index', compact('dokumen'));
    }

    public function dokumenStore(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'file_dokumen' => 'required|mimes:pdf|max:10240', // max 10MB
            'status_tag' => 'required|string|max:255',
            'tanggal_rilis' => 'required|date',
        ]);

        $path = $request->file('file_dokumen')->store('dokumen_perhubungan', 'public');

        DokumenPerhubungan::create([
            'judul' => $validated['judul'],
            'file_path' => $path,
            'status_tag' => $validated['status_tag'],
            'tanggal_rilis' => $validated['tanggal_rilis'],
        ]);

        return redirect()->route('perhubungan.dokumen.index')->with('success', 'Dokumen berhasil diunggah.');
    }

    public function dokumenUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'file_dokumen' => 'nullable|mimes:pdf|max:10240',
            'status_tag' => 'required|string|max:255',
            'tanggal_rilis' => 'required|date',
        ]);

        $dokumen = DokumenPerhubungan::findOrFail($id);

        if ($request->hasFile('file_dokumen')) {
            if ($dokumen->file_path && Storage::disk('public')->exists($dokumen->file_path)) {
                Storage::disk('public')->delete($dokumen->file_path);
            }
            $path = $request->file('file_dokumen')->store('dokumen_perhubungan', 'public');
            $dokumen->file_path = $path;
        }

        $dokumen->judul = $validated['judul'];
        $dokumen->status_tag = $validated['status_tag'];
        $dokumen->tanggal_rilis = $validated['tanggal_rilis'];
        $dokumen->save();

        return redirect()->route('perhubungan.dokumen.index')->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function dokumenDestroy($id)
    {
        $dokumen = DokumenPerhubungan::findOrFail($id);
        
        if ($dokumen->file_path && Storage::disk('public')->exists($dokumen->file_path)) {
            Storage::disk('public')->delete($dokumen->file_path);
        }
        
        $dokumen->delete();
        return redirect()->route('perhubungan.dokumen.index')->with('success', 'Dokumen berhasil dihapus.');
    }
}
