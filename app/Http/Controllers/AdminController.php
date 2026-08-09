<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Division;
use App\Models\ActivityLog;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'aktif')->count();
        $totalDivisions = Division::count();
        $inactiveAccess = User::where('status', 'nonaktif')->count();
        
        $recentActivities = ActivityLog::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers', 
            'activeUsers', 
            'totalDivisions', 
            'inactiveAccess',
            'recentActivities'
        ));
    }

    public function users()
    {
        $users = User::with('division')->paginate(10);
        return view('admin.users.index', compact('users'));
    }
}
