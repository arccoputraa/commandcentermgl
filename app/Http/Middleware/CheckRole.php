<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role !== $role) {
            // Jika user tidak punya akses, redirect dengan pesan error
            // Redirect ke dashboard perizinan jika dia dari divisi perizinan
            $user = Auth::user();
            if ($user->division && strtolower($user->division->name) === 'perizinan') {
                return redirect()->route('perizinan.dashboard')->withErrors(['Hak Akses' => 'Anda tidak memiliki akses ke halaman Admin.']);
            }
            
            return redirect()->route('home')->withErrors(['Hak Akses' => 'Anda tidak memiliki hak akses ke halaman tersebut.']);
        }

        return $next($request);
    }
}
