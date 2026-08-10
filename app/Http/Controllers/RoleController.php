<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $users = \App\Models\User::with('division')->paginate(10);
        $divisions = \App\Models\Division::all(); // for the modal dropdown
        $allUsers = \App\Models\User::all(); // for the "Tambah" modal dropdown
        
        return view('admin.roles.index', compact('users', 'divisions', 'allUsers'));
    }

    public function update(Request $request, \App\Models\User $role)
    {
        // the parameter is $role because Route::resource('roles', RoleController::class) uses 'role' as wildcard
        $user = $role; 
        
        $request->validate([
            'division_id' => 'nullable|exists:divisions,id',
            'role' => 'required|in:admin,user',
            'permissions' => 'nullable|array',
        ]);

        $user->update([
            'division_id' => $request->division_id,
            'role' => $request->role,
            'permissions' => $request->permissions ?? [],
        ]);

        return redirect()->route('admin.roles.index')->with('success', 'Hak akses pengguna berhasil diperbarui.');
    }

    public function destroy(\App\Models\User $role)
    {
        $user = $role;
        $user->update(['permissions' => []]);
        return redirect()->route('admin.roles.index')->with('success', 'Hak akses berhasil dihapus dari sistem.');
    }
}
