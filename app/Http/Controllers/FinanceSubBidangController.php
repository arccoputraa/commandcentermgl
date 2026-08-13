<?php

namespace App\Http\Controllers;

use App\Models\FinanceSubBidang;
use Illuminate\Http\Request;

class FinanceSubBidangController extends Controller
{
    public function index(Request $request)
    {
        $query = FinanceSubBidang::query();
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama_unit', 'like', "%{$search}%")
                  ->orWhere('kode_unit', 'like', "%{$search}%");
        }
        
        $subbidangs = $query->orderBy('created_at', 'desc')->get();
        return view('finance.subbidang.index', compact('subbidangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_unit' => 'required|string',
            'kode_unit' => 'required|string',
            'status' => 'required|string',
            'deskripsi' => 'nullable|string',
            'jumlah_staff' => 'nullable|integer'
        ]);

        FinanceSubBidang::create($request->all());

        return redirect()->route('finance.subbidang.index')->with('success', 'Sub bidang berhasil ditambahkan.');
    }

    public function show($id)
    {
        $subbidang = FinanceSubBidang::findOrFail($id);
        return view('finance.subbidang.detail', compact('subbidang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_unit' => 'required|string',
            'kode_unit' => 'required|string',
            'status' => 'required|string',
            'deskripsi' => 'nullable|string',
            'jumlah_staff' => 'nullable|integer'
        ]);

        $subbidang = FinanceSubBidang::findOrFail($id);
        $subbidang->update($request->all());

        return redirect()->route('finance.subbidang.index')->with('success', 'Sub bidang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $subbidang = FinanceSubBidang::findOrFail($id);
        $subbidang->delete();

        return redirect()->route('finance.subbidang.index')->with('success', 'Sub bidang berhasil dihapus.');
    }
}
