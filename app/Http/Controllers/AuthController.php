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
            \App\Helpers\LogHelper::record_activity($user, 'login', 'berhasil login ke sistem');

            // If super admin, directly redirect to main admin dashboard
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            // Check roles first if explicitly set
            if ($user->role === 'admin_sig') {
                return redirect()->route('sig.dashboard');
            }
            if ($user->role === 'admin_perhubungan') {
                return redirect()->route('perhubungan.dashboard');
            }

            // Check divisions
            if ($user->division) {
                $divName = strtolower($user->division->name);
                
                // Peta manual untuk divisi yang nama routenya berbeda dengan nama divisinya
                $routeMap = [
                    'keuangan' => 'finance'
                ];
                
                $routePrefix = $routeMap[$divName] ?? $divName;
                
                if (\Illuminate\Support\Facades\Route::has("{$routePrefix}.dashboard")) {
                    return redirect()->route("{$routePrefix}.dashboard");
                }
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
            $user = Auth::user();
            
            // Log eksplisit untuk Super Admin agar tidak terkait divisi terakhir yang dikunjungi
            if ($user->role === 'admin') {
                \App\Helpers\LogHelper::record_activity($user, 'logout', 'logout dari Dashboard Global Admin');
            } else {
                \App\Helpers\LogHelper::record_activity($user, 'logout', 'logout dari sistem');
            }
        }

        Auth::logout();
        
        // Bersihkan seluruh data session (termasuk current_active_dashboard) secara eksplisit
        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
