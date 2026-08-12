<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $layout = 'layouts.admin'; // Default layout

        if ($user->division) {
            $divisionName = strtolower($user->division->name);
            if ($divisionName === 'keuangan') {
                $layout = 'layouts.finance';
            } elseif (view()->exists('layouts.' . $divisionName)) {
                $layout = 'layouts.' . $divisionName;
            }
        }

        return view('profile.index', compact('user', 'layout'));
    }

    public function edit()
    {
        $user = Auth::user();
        $layout = 'layouts.admin';

        if ($user->division) {
            $divisionName = strtolower($user->division->name);
            if ($divisionName === 'keuangan') {
                $layout = 'layouts.finance';
            } elseif (view()->exists('layouts.' . $divisionName)) {
                $layout = 'layouts.' . $divisionName;
            }
        }

        return view('profile.edit', compact('user', 'layout'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'nip' => 'nullable|string|max:50',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->nip = $request->nip;

        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui.');
    }
}
