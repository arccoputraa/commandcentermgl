<?php

namespace App\Http\Controllers;

use App\Models\FinancePad;
use Illuminate\Http\Request;

class FinancePadController extends Controller
{
    public function index(Request $request)
    {
        $query = FinancePad::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('sumber_pendapatan', 'like', "%{$search}%")
                  ->orWhere('sub_bidang', 'like', "%{$search}%")
                  ->orWhere('tahun', 'like', "%{$search}%");
        }

        $pads = $query->orderBy('tahun', 'desc')->orderBy('created_at', 'desc')->get();

        return view('finance.pad.index', compact('pads'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun' => 'required|integer',
            'sub_bidang' => 'required|string|max:255',
            'sumber_pendapatan' => 'required|string|max:255',
            'target_pad' => 'required|numeric',
            'realisasi_pad' => 'required|numeric',
            'periode' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'catatan_internal' => 'nullable|string'
        ]);

        FinancePad::create($validated);

        return redirect()->route('finance.pad.index')->with('success', 'Data PAD berhasil ditambahkan');
    }

    public function show($id)
    {
        $pad = FinancePad::findOrFail($id);
        return view('finance.pad.detail', compact('pad'));
    }

    public function update(Request $request, $id)
    {
        $pad = FinancePad::findOrFail($id);
        
        $validated = $request->validate([
            'tahun' => 'required|integer',
            'sub_bidang' => 'required|string|max:255',
            'sumber_pendapatan' => 'required|string|max:255',
            'target_pad' => 'required|numeric',
            'realisasi_pad' => 'required|numeric',
            'periode' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'catatan_internal' => 'nullable|string'
        ]);

        $pad->update($validated);

        return redirect()->route('finance.pad.index')->with('success', 'Data PAD berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pad = FinancePad::findOrFail($id);
        $pad->delete();

        return redirect()->route('finance.pad.index')->with('success', 'Data PAD berhasil dihapus');
    }
}
