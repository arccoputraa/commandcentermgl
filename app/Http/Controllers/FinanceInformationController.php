<?php

namespace App\Http\Controllers;

use App\Models\FinanceInformation;
use Illuminate\Http\Request;

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
            'keterangan' => 'nullable|string'
        ]);

        FinanceInformation::create($request->all());

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
            'keterangan' => 'nullable|string'
        ]);

        $information = FinanceInformation::findOrFail($id);
        $information->update($request->all());

        return redirect()->route('finance.information.index')->with('success', 'Informasi terbaru berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $information = FinanceInformation::findOrFail($id);
        $information->delete();

        return redirect()->route('finance.information.index')->with('success', 'Informasi terbaru berhasil dihapus.');
    }
}
