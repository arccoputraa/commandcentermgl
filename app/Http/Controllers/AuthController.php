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
            $request->session()->regenerate();
            
            // Log activity
            \App\Models\ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'login',
                'description' => 'Login ke dalam sistem admin.',
            ]);

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
