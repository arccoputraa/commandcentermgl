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
            $targetModule = 'Dashboard Global Admin';
            if ($user->role === 'division_admin' && $user->division) {
                $targetModule = 'Dashboard ' . $user->division->name;
            } elseif ($user->role === 'admin_sig') {
                $targetModule = 'Dashboard SIG';
            } elseif ($user->role === 'admin_perhubungan') {
                $targetModule = 'Dashboard Perhubungan';
            }
            
            \App\Helpers\LogHelper::record_activity($user, 'login ke', $targetModule);

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
            $targetModule = 'Dashboard Global Admin';
            if ($user->role === 'division_admin' && $user->division) {
                $targetModule = 'Dashboard ' . $user->division->name;
            } elseif ($user->role === 'admin_sig') {
                $targetModule = 'Dashboard SIG';
            } elseif ($user->role === 'admin_perhubungan') {
                $targetModule = 'Dashboard Perhubungan';
            }
            \App\Helpers\LogHelper::record_activity($user, 'logout dari', $targetModule);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
