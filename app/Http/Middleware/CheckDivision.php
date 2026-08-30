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
        if ($user->role === 'admin') {
            return $next($request);
        }

        // Check if the user belongs to the required division
        if (!$user->division || strtolower($user->division->name) !== strtolower($divisionName)) {
            // User doesn't have access, redirect them to their own dashboard or home
            if ($user->division) {
                $userDiv = strtolower($user->division->name);
                // Redirect them to their respective division dashboard if it exists
                if (in_array($userDiv, ['pembangunan', 'perizinan', 'kesehatan', 'keuangan', 'kepegawaian', 'kependudukan', 'sig', 'perhubungan'])) {
                    return redirect()->route("{$userDiv}.dashboard")->withErrors(['Hak Akses' => "Anda tidak memiliki akses ke halaman divisi {$divisionName}."]);
                }
            }
            return redirect()->route('home')->withErrors(['Hak Akses' => "Anda tidak memiliki hak akses ke halaman divisi {$divisionName}."]);
        }

        return $next($request);
    }
}
