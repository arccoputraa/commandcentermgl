<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function dashboard()
    {
        return view('finance.dashboard');
    }
}
