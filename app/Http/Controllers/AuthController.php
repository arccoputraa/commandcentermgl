<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            if ($user->status !== 'aktif') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Akun Anda sedang dinonaktifkan. Silakan hubungi administrator.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();
            
            // Log activity
            \App\Models\ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'login',
                'description' => 'Login ke dalam sistem admin.',
            ]);

            $user = Auth::user();
            if ($user->division && strtolower($user->division->name) === 'perizinan') {
                return redirect()->route('perizinan.dashboard');
            }
            if ($user->division && strtolower($user->division->name) === 'kesehatan') {
                return redirect()->route('kesehatan.dashboard');
            }

            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        // Log activity before logout
        if (Auth::check()) {
            \App\Models\ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'logout',
                'description' => 'Logout dari sistem admin.',
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
