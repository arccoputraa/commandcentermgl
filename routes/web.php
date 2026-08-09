<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/tentang', function () {
    return view('tentang');
})->name('tentang');

Route::get('/cctv', function () {
    return view('cctv');
})->name('cctv');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/layanan', function (Request $request) {
    $dept = $request->query('dept');
    
    // Fallback to generic layanan if specific view doesn't exist
    if ($dept && view()->exists("layanan.{$dept}")) {
        return view("layanan.{$dept}");
    }
    
    return view('layanan', ['dept' => $dept]);
})->name('layanan');

Route::post('/login', [\App\Http\Controllers\AuthController::class, 'authenticate'])->name('login.post');
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Admin Routes (protected)
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('admin.users.index');
});

Route::get('/{page}', function (Request $request, string $page) {
    $viewName = preg_replace('/\.(blade\.php|html)$/', '', $page);

    if ($page !== $viewName) {
        $queryString = $request->getQueryString();
        $url = '/' . $viewName . ($queryString ? '?' . $queryString : '');
        return redirect()->to($url);
    }

    if (in_array($viewName, ['index', 'tentang', 'cctv', 'login', 'layanan'], true) && view()->exists($viewName)) {
        return view($viewName);
    }

    abort(404);
})->where('page', '.*');
