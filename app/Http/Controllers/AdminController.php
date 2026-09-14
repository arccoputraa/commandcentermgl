<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use App\Models\User;
use App\Models\Division;
use App\Models\ActivityLog;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Log access back to Global Admin for Super Admins
        $sessionKey = 'accessed_div_global';
        if (!session()->has($sessionKey)) {
            \App\Helpers\LogHelper::record_activity(\Illuminate\Support\Facades\Auth::user(), 'kembali ke', 'Dashboard Global Admin');
            session()->put($sessionKey, true);
        }

        $totalUsers = User::count();
        $activeUsers = User::where('status', 'aktif')->count();
        $totalDivisions = Division::count();
        $inactiveAccess = User::where('status', 'nonaktif')->count();
        
        $recentActivities = ActivityLog::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers', 
            'activeUsers', 
            'totalDivisions', 
            'inactiveAccess',
            'recentActivities'
        ));
    }

    public function users(Request $request)
    {
        $query = User::with('division')
            ->orderByRaw("CASE WHEN role = 'admin' THEN 1 WHEN role = 'division_admin' THEN 2 ELSE 3 END")
            ->orderBy('name', 'asc');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(10)->withQueryString();
        
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $divisions = Division::all();
        return view('admin.users.create', compact('divisions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nip' => 'nullable|string|max:50',
            'division_id' => 'required_unless:role,admin|nullable|exists:divisions,id',
            'role' => 'required|in:admin,division_admin,user',
            'status' => 'required|in:aktif,nonaktif',
        ], [
            'division_id.required_unless' => 'Divisi wajib dipilih jika role adalah Admin Divisi atau User.'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nip' => $request->nip,
            'division_id' => $request->division_id,
            'role' => $request->role,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        $activities = \App\Models\ActivityLog::where('user_id', $user->id)->latest()->get();
        return view('admin.users.show', compact('user', 'activities'));
    }

    public function edit(User $user)
    {
        $divisions = Division::all();
        return view('admin.users.edit', compact('user', 'divisions'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'nip' => 'nullable|string|max:50',
            'division_id' => 'required_unless:role,admin|nullable|exists:divisions,id',
            'role' => 'required|in:admin,division_admin,user',
            'status' => 'required|in:aktif,nonaktif',
        ], [
            'division_id.required_unless' => 'Divisi wajib dipilih jika role adalah Admin Divisi atau User.'
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'nip' => $request->nip,
            'division_id' => $request->division_id,
            'role' => $request->role,
            'status' => $request->status,
        ];
        
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('admin.users.index')->with('success', 'Informasi pengguna berhasil diubah.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Hak akses berhasil dihapus dari sistem.');
    }
}
