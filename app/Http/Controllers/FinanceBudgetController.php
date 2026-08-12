<?php

namespace App\Http\Controllers;

use App\Models\FinanceBudget;
use Illuminate\Http\Request;

class FinanceBudgetController extends Controller
{
    public function index(Request $request)
    {
        $query = FinanceBudget::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama_anggaran', 'like', "%{$search}%")
                  ->orWhere('sub_bidang', 'like', "%{$search}%");
        }

        $budgets = $query->orderBy('tahun', 'desc')->orderBy('created_at', 'desc')->get();

        return view('finance.budget.index', compact('budgets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun' => 'required|integer',
            'sub_bidang' => 'required|string|max:255',
            'nama_anggaran' => 'required|string|max:255',
            'total_anggaran' => 'required|numeric',
            'total_realisasi' => 'required|numeric',
            'periode' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'catatan_internal' => 'nullable|string'
        ]);

        FinanceBudget::create($validated);

        return redirect()->route('finance.budget.index')->with('success', 'Data Anggaran berhasil ditambahkan');
    }

    public function show($id)
    {
        $budget = FinanceBudget::findOrFail($id);
        return view('finance.budget.detail', compact('budget'));
    }

    public function update(Request $request, $id)
    {
        $budget = FinanceBudget::findOrFail($id);
        
        $validated = $request->validate([
            'tahun' => 'required|integer',
            'sub_bidang' => 'required|string|max:255',
            'nama_anggaran' => 'required|string|max:255',
            'total_anggaran' => 'required|numeric',
            'total_realisasi' => 'required|numeric',
            'periode' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'catatan_internal' => 'nullable|string'
        ]);

        $budget->update($validated);

        return redirect()->route('finance.budget.index')->with('success', 'Data Anggaran berhasil diperbarui');
    }

    public function destroy($id)
    {
        $budget = FinanceBudget::findOrFail($id);
        $budget->delete();

        return redirect()->route('finance.budget.index')->with('success', 'Data Anggaran berhasil dihapus');
    }
}
