<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckDivision
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $divisionName): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Admin can access everything
        if ($user->isSuperAdmin()) {
            $divisionKey = strtolower($divisionName);
            
            // Cek apakah baru saja beralih ke divisi ini
            if (session()->get('current_active_dashboard') !== $divisionKey) {
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
                $actualName = $nameMap[$divisionKey] ?? ucfirst($divisionName);
                
                \App\Helpers\LogHelper::record_activity($user, 'access', 'beralih ke Dashboard ' . $actualName);
                
                // Simpan state divisi yang sedang aktif (hanya 1)
                session()->put('current_active_dashboard', $divisionKey);
            }
            return $next($request);
        }

        // Check if the user belongs to the required division
        if (!$user->division || strtolower($user->division->name) !== strtolower($divisionName)) {
            // User doesn't have access, redirect them to their own dashboard or home
            if ($user->division) {
                $userDiv = strtolower($user->division->name);
                // Redirect them to their respective division dashboard if it exists
                if (\Illuminate\Support\Facades\Route::has("{$userDiv}.dashboard")) {
                    return redirect()->route("{$userDiv}.dashboard")->withErrors(['Hak Akses' => "Anda tidak memiliki akses ke halaman divisi {$divisionName}."]);
                }
            }
            return redirect()->route('home')->withErrors(['Hak Akses' => "Anda tidak memiliki hak akses ke halaman divisi {$divisionName}."]);
        }

        return $next($request);
    }
}
