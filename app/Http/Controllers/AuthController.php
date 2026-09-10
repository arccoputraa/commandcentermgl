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
            $desc = 'login ke Dashboard Global Admin.';
            if ($user->role === 'division_admin' && $user->division) {
                $desc = 'login ke Dashboard ' . $user->division->name . '.';
            }

            \App\Models\ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'login',
                'description' => $desc,
            ]);

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
                if ($divName === 'sig') {
                    return redirect()->route('sig.dashboard');
                }
                if ($divName === 'perhubungan') {
                    return redirect()->route('perhubungan.dashboard');
                }
                if ($divName === 'perizinan') {
                    return redirect()->route('perizinan.dashboard');
                }
                if ($divName === 'kesehatan') {
                    return redirect()->route('kesehatan.dashboard');
                }
                if ($divName === 'keuangan') {
                    return redirect()->route('finance.dashboard');
                }
                if ($divName === 'kepegawaian') {
                    return redirect()->route('kepegawaian.dashboard');
                }
                if ($divName === 'pembangunan') {
                    return redirect()->route('pembangunan.dashboard');
                }
                if ($divName === 'kependudukan') {
                    return redirect()->route('kependudukan.dashboard');
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
            $desc = 'logout dari Dashboard Global Admin.';
            if ($user->role === 'division_admin' && $user->division) {
                $desc = 'logout dari Dashboard ' . $user->division->name . '.';
            }
            \App\Models\ActivityLog::create([
                'user_id' => $user->id,
                'action' => 'logout',
                'description' => $desc,
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
