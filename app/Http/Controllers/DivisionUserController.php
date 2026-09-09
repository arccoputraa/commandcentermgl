<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DivisionUserController extends Controller
{
    private function getDivision($slug)
    {
        $nameMap = [
            'finance' => 'Keuangan',
            'perizinan' => 'Perizinan',
            'kesehatan' => 'Kesehatan',
            'kepegawaian' => 'Kepegawaian',
            'kependudukan' => 'Kependudukan',
            'pembangunan' => 'Pembangunan',
            'perhubungan' => 'Perhubungan',
            'sig' => 'SIG',
        ];
        $actualName = $nameMap[strtolower($slug)] ?? $slug;
        return Division::where('name', $actualName)->firstOrFail();
    }

    /**
     * Display a listing of the resource.
     */
    public function index($division_slug)
    {
        $user = Auth::user();
        
        // Find division
        $division = $this->getDivision($division_slug);

        // Admin can view any division users. Division Admin can only view their own.
        if ($user->role === 'division_admin' && $user->division_id !== $division->id) {
            abort(403, 'Unauthorized action.');
        }

        $users = User::where('division_id', $division->id)
                     ->where('id', '!=', 1) // don't show super admin
                     ->orderBy('name')
                     ->get();

        // To determine the correct view layout
        return view('division_users.index', compact('users', 'division', 'division_slug'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($division_slug)
    {
        $user = Auth::user();
        $division = $this->getDivision($division_slug);

        if ($user->role === 'division_admin' && $user->division_id !== $division->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('division_users.create', compact('division', 'division_slug'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $division_slug)
    {
        $user = Auth::user();
        $division = $this->getDivision($division_slug);

        if ($user->role === 'division_admin' && $user->division_id !== $division->id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'nip' => ['nullable', 'string', 'max:50', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'status' => ['required', 'string', 'in:aktif,nonaktif'],
            'permissions' => ['nullable', 'array'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nip' => $request->nip,
            'password' => Hash::make($request->password),
            'division_id' => $division->id, // locked to this division
            'role' => 'user', // only allowed to create regular user
            'status' => $request->status,
            'permissions' => $request->permissions ?? [],
        ]);

        return redirect()->route('division.users.index', $division_slug)->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($division_slug, User $user)
    {
        $currentUser = Auth::user();
        $division = $this->getDivision($division_slug);

        if ($currentUser->role === 'division_admin' && $currentUser->division_id !== $division->id) {
            abort(403, 'Unauthorized action.');
        }

        // Ensure the user being edited belongs to this division
        if ($user->division_id !== $division->id) {
            abort(404);
        }

        return view('division_users.edit', compact('user', 'division', 'division_slug'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $division_slug, User $user)
    {
        $currentUser = Auth::user();
        $division = $this->getDivision($division_slug);

        if ($currentUser->role === 'division_admin' && $currentUser->division_id !== $division->id) {
            abort(403, 'Unauthorized action.');
        }

        if ($user->division_id !== $division->id) {
            abort(404);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'nip' => ['nullable', 'string', 'max:50', Rule::unique('users')->ignore($user->id)],
            'status' => ['required', 'string', 'in:aktif,nonaktif'],
            'permissions' => ['nullable', 'array'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'nip' => $request->nip,
            'status' => $request->status,
            'permissions' => $request->permissions ?? [],
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => ['string', 'min:8', 'confirmed']]);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('division.users.index', $division_slug)->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($division_slug, User $user)
    {
        $currentUser = Auth::user();
        $division = $this->getDivision($division_slug);

        if ($currentUser->role === 'division_admin' && $currentUser->division_id !== $division->id) {
            abort(403, 'Unauthorized action.');
        }

        if ($user->division_id !== $division->id) {
            abort(404);
        }

        $user->delete();

        return redirect()->route('division.users.index', $division_slug)->with('success', 'User berhasil dihapus.');
    }
}
