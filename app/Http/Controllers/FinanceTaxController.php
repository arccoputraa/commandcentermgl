<?php

namespace App\Http\Controllers;

use App\Models\FinanceTax;
use Illuminate\Http\Request;

class FinanceTaxController extends Controller
{
    public function index(Request $request)
    {
        $query = FinanceTax::query();
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('jenis_pajak', 'like', "%{$search}%")
                  ->orWhere('kecamatan', 'like', "%{$search}%")
                  ->orWhere('kelurahan', 'like', "%{$search}%")
                  ->orWhere('bulan', 'like', "%{$search}%");
        }
        
        $taxes = $query->orderBy('created_at', 'desc')->get();
        return view('finance.tax.index', compact('taxes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bulan' => 'required|string',
            'tahun' => 'required|integer',
            'jenis_pajak' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'jumlah_pendapatan' => 'required|numeric',
            'keterangan' => 'nullable|string'
        ]);

        FinanceTax::create($request->all());

        return redirect()->route('finance.tax.index')->with('success', 'Data pajak daerah berhasil ditambahkan.');
    }

    public function show($id)
    {
        $tax = FinanceTax::findOrFail($id);
        return view('finance.tax.detail', compact('tax'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'bulan' => 'required|string',
            'tahun' => 'required|integer',
            'jenis_pajak' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'jumlah_pendapatan' => 'required|numeric',
            'keterangan' => 'nullable|string'
        ]);

        $tax = FinanceTax::findOrFail($id);
        $tax->update($request->all());

        return redirect()->route('finance.tax.index')->with('success', 'Data pajak daerah berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tax = FinanceTax::findOrFail($id);
        $tax->delete();

        return redirect()->route('finance.tax.index')->with('success', 'Data pajak daerah berhasil dihapus.');
    }
}
