<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function index()
    {
        $divisions = \App\Models\Division::withCount('users')->paginate(10);
        return view('admin.divisions.index', compact('divisions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
            'type' => 'required|in:internal,eksternal',
        ]);

        \App\Models\Division::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'type' => $request->type,
        ]);

        return redirect()->route('admin.divisions.index')->with('success', 'Divisi berhasil ditambahkan.');
    }

    public function update(Request $request, \App\Models\Division $division)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
            'type' => 'required|in:internal,eksternal',
        ]);

        $division->update([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'type' => $request->type,
        ]);

        return redirect()->route('admin.divisions.index')->with('success', 'Divisi berhasil diperbarui.');
    }

    public function destroy(\App\Models\Division $division)
    {
        if ($division->users()->count() > 0) {
            return redirect()->route('admin.divisions.index')->withErrors(['error' => 'Divisi tidak bisa dihapus karena masih memiliki pengguna.']);
        }
        $division->delete();
        return redirect()->route('admin.divisions.index')->with('success', 'Divisi berhasil dihapus.');
    }
}
