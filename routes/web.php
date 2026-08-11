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
    
    if ($dept === 'perizinan') {
        $dataPerizinan = \App\Models\PerizinanData::with('jenisIzin')
                            ->orderBy('created_at', 'desc')
                            ->limit(10)
                            ->get();
        $publikasi = \App\Models\PerizinanPublikasi::where('status', 'Aktif')
                            ->orderBy('created_at', 'desc')
                            ->get();
                            
        // Hitung statistik untuk cards
        $stats = [
            'total' => \App\Models\PerizinanData::count(),
            'disetujui' => \App\Models\PerizinanData::where('status', 'Disetujui')->count(),
            'proses' => \App\Models\PerizinanData::where('status', 'Proses')->count(),
            'ditolak' => \App\Models\PerizinanData::where('status', 'Ditolak')->count(),
            'baru' => \App\Models\PerizinanData::where('jenis_permohonan', 'Baru')->count(),
            'perpanjangan' => \App\Models\PerizinanData::where('jenis_permohonan', 'Perpanjangan')->count(),
            'lainnya' => \App\Models\PerizinanData::whereNotIn('jenis_permohonan', ['Baru', 'Perpanjangan'])->count(),
        ];
        
        // Data untuk grafik bulanan tahun ini
        $currentYear = date('Y');
        $monthlyData = \App\Models\PerizinanData::selectRaw("CAST(strftime('%m', tanggal) AS INTEGER) as month, status, count(*) as total")
                            ->whereYear('tanggal', $currentYear)
                            ->groupBy('month', 'status')
                            ->get();
                            
        $chartData = [
            'total_bulanan' => array_fill(1, 12, 0),
            'disetujui_bulanan' => array_fill(1, 12, 0),
            'proses_bulanan' => array_fill(1, 12, 0)
        ];
        
        foreach ($monthlyData as $row) {
            $chartData['total_bulanan'][$row->month] += $row->total;
            if ($row->status == 'Disetujui') {
                $chartData['disetujui_bulanan'][$row->month] += $row->total;
            } elseif ($row->status == 'Proses') {
                $chartData['proses_bulanan'][$row->month] += $row->total;
            }
        }
        
        if (view()->exists('layanan.perizinan')) {
            return view('layanan.perizinan', compact('dataPerizinan', 'publikasi', 'dept', 'stats', 'chartData'));
        }
    }
    
    // Fallback to generic layanan if specific view doesn't exist
    if ($dept && view()->exists("layanan.{$dept}")) {
        return view("layanan.{$dept}");
    }
    
    return view('layanan', ['dept' => $dept]);
})->name('layanan');

Route::post('/login', [\App\Http\Controllers\AuthController::class, 'authenticate'])->name('login.post');
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Admin Routes (protected)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('admin.users.index');
    Route::get('/users/create', [\App\Http\Controllers\AdminController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [\App\Http\Controllers\AdminController::class, 'store'])->name('admin.users.store');
    Route::delete('/users/{user}', [\App\Http\Controllers\AdminController::class, 'destroy'])->name('admin.users.destroy');
    
    // Divisions
    Route::get('/divisions', [\App\Http\Controllers\DivisionController::class, 'index'])->name('admin.divisions.index');
    Route::post('/divisions', [\App\Http\Controllers\DivisionController::class, 'store'])->name('admin.divisions.store');
    Route::put('/divisions/{division}', [\App\Http\Controllers\DivisionController::class, 'update'])->name('admin.divisions.update');
    Route::delete('/divisions/{division}', [\App\Http\Controllers\DivisionController::class, 'destroy'])->name('admin.divisions.destroy');

    // Roles / Permissions
    Route::get('/roles', [\App\Http\Controllers\RoleController::class, 'index'])->name('admin.roles.index');
    Route::put('/roles/{role}', [\App\Http\Controllers\RoleController::class, 'update'])->name('admin.roles.update');
    Route::delete('/roles/{role}', [\App\Http\Controllers\RoleController::class, 'destroy'])->name('admin.roles.destroy');
});

// Perizinan Routes (protected)
Route::middleware('auth')->prefix('perizinan')->group(function () {
    Route::get('/', [\App\Http\Controllers\PerizinanController::class, 'dashboard'])->name('perizinan.dashboard');
    
    // Data Perizinan
    Route::get('/data', [\App\Http\Controllers\PerizinanController::class, 'dataIndex'])->name('perizinan.data.index');
    Route::get('/data/create', [\App\Http\Controllers\PerizinanController::class, 'dataCreate'])->name('perizinan.data.create');
    Route::post('/data', [\App\Http\Controllers\PerizinanController::class, 'dataStore'])->name('perizinan.data.store');
    Route::get('/data/{data}/edit', [\App\Http\Controllers\PerizinanController::class, 'dataEdit'])->name('perizinan.data.edit');
    Route::put('/data/{data}', [\App\Http\Controllers\PerizinanController::class, 'dataUpdate'])->name('perizinan.data.update');
    Route::delete('/data/{data}', [\App\Http\Controllers\PerizinanController::class, 'dataDestroy'])->name('perizinan.data.destroy');

    // Jenis Izin & SLA
    Route::get('/jenis', [\App\Http\Controllers\PerizinanController::class, 'jenisIndex'])->name('perizinan.jenis.index');
    Route::get('/jenis/create', [\App\Http\Controllers\PerizinanController::class, 'jenisCreate'])->name('perizinan.jenis.create');
    Route::post('/jenis', [\App\Http\Controllers\PerizinanController::class, 'jenisStore'])->name('perizinan.jenis.store');
    Route::get('/jenis/{jenis}/edit', [\App\Http\Controllers\PerizinanController::class, 'jenisEdit'])->name('perizinan.jenis.edit');
    Route::put('/jenis/{jenis}', [\App\Http\Controllers\PerizinanController::class, 'jenisUpdate'])->name('perizinan.jenis.update');
    Route::delete('/jenis/{jenis}', [\App\Http\Controllers\PerizinanController::class, 'jenisDestroy'])->name('perizinan.jenis.destroy');

    // Publikasi Masyarakat
    Route::get('/publikasi', [\App\Http\Controllers\PerizinanController::class, 'publikasiIndex'])->name('perizinan.publikasi.index');
    Route::get('/publikasi/create', [\App\Http\Controllers\PerizinanController::class, 'publikasiCreate'])->name('perizinan.publikasi.create');
    Route::post('/publikasi', [\App\Http\Controllers\PerizinanController::class, 'publikasiStore'])->name('perizinan.publikasi.store');
    Route::get('/publikasi/{publikasi}/edit', [\App\Http\Controllers\PerizinanController::class, 'publikasiEdit'])->name('perizinan.publikasi.edit');
    Route::put('/publikasi/{publikasi}', [\App\Http\Controllers\PerizinanController::class, 'publikasiUpdate'])->name('perizinan.publikasi.update');
    Route::delete('/publikasi/{publikasi}', [\App\Http\Controllers\PerizinanController::class, 'publikasiDestroy'])->name('perizinan.publikasi.destroy');
});

// Kesehatan Routes (protected)
Route::middleware('auth')->prefix('kesehatan')->group(function () {
    Route::get('/', [\App\Http\Controllers\KesehatanController::class, 'dashboard'])->name('kesehatan.dashboard');
    
    // Program Kesehatan
    Route::get('/program', [\App\Http\Controllers\KesehatanController::class, 'programIndex'])->name('kesehatan.program.index');
    Route::get('/program/{id}', [\App\Http\Controllers\KesehatanController::class, 'programDetail'])->name('kesehatan.program.detail');
    
    // Data Penyakit
    Route::get('/penyakit', [\App\Http\Controllers\KesehatanController::class, 'penyakitIndex'])->name('kesehatan.penyakit.index');
    Route::post('/penyakit', [\App\Http\Controllers\KesehatanController::class, 'penyakitStore'])->name('kesehatan.penyakit.store');
    Route::get('/penyakit/{id}', [\App\Http\Controllers\KesehatanController::class, 'penyakitDetail'])->name('kesehatan.penyakit.detail');
    Route::put('/penyakit/{id}', [\App\Http\Controllers\KesehatanController::class, 'penyakitUpdate'])->name('kesehatan.penyakit.update');
    Route::delete('/penyakit/{id}', [\App\Http\Controllers\KesehatanController::class, 'penyakitDestroy'])->name('kesehatan.penyakit.destroy');
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
