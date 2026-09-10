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
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Normalize roles array in case Laravel passes them as a single comma-separated string
        $normalizedRoles = [];
        foreach ($roles as $role) {
            if (strpos($role, ',') !== false) {
                $normalizedRoles = array_merge($normalizedRoles, explode(',', $role));
            } else {
                $normalizedRoles[] = $role;
            }
        }

        // Allow super admin if 'admin' is in allowed roles
        if (in_array('admin', $normalizedRoles) && $user->isSuperAdmin()) {
            return $next($request);
        }

        if (!in_array($user->role, $normalizedRoles)) {
            // Jika user tidak punya akses, redirect dengan pesan error
            // Redirect ke dashboard masing-masing jika dia punya divisi
            if ($user->division) {
                $userDiv = strtolower($user->division->name);
                if (\Illuminate\Support\Facades\Route::has("{$userDiv}.dashboard")) {
                    return redirect()->route("{$userDiv}.dashboard")->withErrors(['Hak Akses' => 'Anda tidak memiliki akses ke halaman tersebut.']);
                }
            }
            
            return redirect()->route('home')->withErrors(['Hak Akses' => 'Anda tidak memiliki hak akses ke halaman tersebut.']);
        }

        return $next($request);
    }
}
