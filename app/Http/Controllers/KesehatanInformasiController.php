<?php

namespace App\Http\Controllers;

use App\Models\KesehatanInformasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KesehatanInformasiController extends Controller
{
    public function index()
    {
        $informasi = KesehatanInformasi::orderBy('created_at', 'desc')->get();
        return view('kesehatan.informasi.index', compact('informasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'file_pdf' => 'required|mimes:pdf|max:10240', // max 10MB
        ]);

        $file = $request->file('file_pdf');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/kesehatan/informasi', $fileName);

        KesehatanInformasi::create([
            'judul' => $request->judul,
            'file_pdf' => $fileName,
        ]);

        return redirect()->route('kesehatan.informasi.index')->with('success', 'Informasi berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'file_pdf' => 'nullable|mimes:pdf|max:10240',
        ]);

        $informasi = KesehatanInformasi::findOrFail($id);

        if ($request->hasFile('file_pdf')) {
            // Delete old file
            if (Storage::exists('public/kesehatan/informasi/' . $informasi->file_pdf)) {
                Storage::delete('public/kesehatan/informasi/' . $informasi->file_pdf);
            }

            $file = $request->file('file_pdf');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/kesehatan/informasi', $fileName);
            $informasi->file_pdf = $fileName;
        }

        $informasi->judul = $request->judul;
        $informasi->save();

        return redirect()->route('kesehatan.informasi.index')->with('success', 'Informasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $informasi = KesehatanInformasi::findOrFail($id);

        // Delete file
        if (Storage::exists('public/kesehatan/informasi/' . $informasi->file_pdf)) {
            Storage::delete('public/kesehatan/informasi/' . $informasi->file_pdf);
        }

        $informasi->delete();

        return redirect()->route('kesehatan.informasi.index')->with('success', 'Informasi berhasil dihapus.');
    }
}
