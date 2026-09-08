<?php

namespace App\Http\Controllers;

use App\Models\FinanceInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FinanceInformationController extends Controller
{
    public function index(Request $request)
    {
        $query = FinanceInformation::query();
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
        }
        
        $informations = $query->orderBy('created_at', 'desc')->get();
        return view('finance.information.index', compact('informations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'kategori' => 'required|string',
            'format' => 'required|string',
            'status_publikasi' => 'required|string',
            'keterangan' => 'nullable|string',
            'dokumen_file' => 'nullable|file|mimes:pdf,xlsx,xls,doc,docx|max:10240',
            'dokumen' => 'nullable|string'
        ]);

        $data = $request->except(['dokumen_file']);

        if ($request->hasFile('dokumen_file')) {
            $path = $request->file('dokumen_file')->store('dokumen', 'public');
            $data['dokumen'] = $path;
        } elseif (empty($data['dokumen'])) {
            $data['dokumen'] = '/sample-document.pdf';
        }

        FinanceInformation::create($data);

        return redirect()->route('finance.information.index')->with('success', 'Informasi terbaru berhasil ditambahkan.');
    }

    public function show($id)
    {
        $information = FinanceInformation::findOrFail($id);
        return view('finance.information.detail', compact('information'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string',
            'kategori' => 'required|string',
            'format' => 'required|string',
            'status_publikasi' => 'required|string',
            'keterangan' => 'nullable|string',
            'dokumen_file' => 'nullable|file|mimes:pdf,xlsx,xls,doc,docx|max:10240',
            'dokumen' => 'nullable|string'
        ]);

        $information = FinanceInformation::findOrFail($id);
        $data = $request->except(['dokumen_file']);

        if ($request->hasFile('dokumen_file')) {
            if ($information->dokumen && !str_starts_with($information->dokumen, 'http') && !str_starts_with($information->dokumen, '/')) {
                Storage::disk('public')->delete($information->dokumen);
            }
            $path = $request->file('dokumen_file')->store('dokumen', 'public');
            $data['dokumen'] = $path;
        }

        $information->update($data);

        return redirect()->route('finance.information.index')->with('success', 'Informasi terbaru berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $information = FinanceInformation::findOrFail($id);
        if ($information->dokumen && !str_starts_with($information->dokumen, 'http') && !str_starts_with($information->dokumen, '/')) {
            Storage::disk('public')->delete($information->dokumen);
        }
        $information->delete();

        return redirect()->route('finance.information.index')->with('success', 'Informasi terbaru berhasil dihapus.');
    }
}
