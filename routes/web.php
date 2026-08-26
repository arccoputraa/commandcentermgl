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
    
    if ($dept === 'kepegawaian') {
        $stats = [
            'total' => \App\Models\PegawaiData::count(),
            'pns' => \App\Models\PegawaiData::where('jenis_pegawai', 'PNS')->count(),
            'pppk' => \App\Models\PegawaiData::where('jenis_pegawai', 'PPPK')->count(),
            'non_asn' => \App\Models\PegawaiData::where('jenis_pegawai', 'Non-ASN')->count(),
        ];
        
        $unitKerjaRaw = \App\Models\PegawaiData::selectRaw('unit_kerja, count(*) as total')->groupBy('unit_kerja')->get();
        $chartUnitKerja = ['labels' => [], 'data' => []];
        foreach($unitKerjaRaw as $u) {
            $chartUnitKerja['labels'][] = $u->unit_kerja ?? 'Lainnya';
            $chartUnitKerja['data'][] = $u->total;
        }

        $genderRaw = \App\Models\PegawaiData::selectRaw('jenis_kelamin, count(*) as total')->groupBy('jenis_kelamin')->get();
        $chartGender = ['Laki-laki' => 0, 'Perempuan' => 0];
        foreach($genderRaw as $g) {
            if ($g->jenis_kelamin == 'Laki-laki' || $g->jenis_kelamin == 'L') $chartGender['Laki-laki'] += $g->total;
            else $chartGender['Perempuan'] += $g->total;
        }

        $golonganRaw = \App\Models\PegawaiData::selectRaw('golongan, count(*) as total')->groupBy('golongan')->get();
        $chartGolongan = ['labels' => [], 'data' => []];
        foreach($golonganRaw as $g) {
            if ($g->golongan) {
                $chartGolongan['labels'][] = $g->golongan;
                $chartGolongan['data'][] = $g->total;
            }
        }

        $mutasiRaw = \App\Models\PegawaiMutasi::selectRaw("CAST(strftime('%m', tanggal_efektif) AS INTEGER) as month, count(*) as total")->whereYear('tanggal_efektif', date('Y'))->groupBy('month')->get();
        $chartMutasi = array_fill(1, 12, 0);
        foreach($mutasiRaw as $m) {
            $chartMutasi[$m->month] = $m->total;
        }

        $informasiTerbaru = \App\Models\PegawaiInformasi::where('status_publikasi', 'Rilis')->orderBy('created_at', 'desc')->limit(3)->get();
        $tabelRingkas = \App\Models\PegawaiMutasi::orderBy('tanggal_efektif', 'desc')->limit(5)->get();

        if (view()->exists('layanan.kepegawaian')) {
            return view('layanan.kepegawaian', compact('stats', 'chartUnitKerja', 'chartGender', 'chartGolongan', 'chartMutasi', 'informasiTerbaru', 'tabelRingkas', 'dept'));
        }
    }

    if ($dept === 'keuangan') {
        $pajakTotal = \App\Models\FinanceTax::sum('jumlah_pendapatan');
        
        $budgets = \App\Models\FinanceBudget::selectRaw('sub_bidang, SUM(total_anggaran) as total_anggaran, SUM(total_realisasi) as total_realisasi')->groupBy('sub_bidang')->get();
        $chartAnggaran = ['labels' => [], 'anggaran' => [], 'realisasi' => []];
        foreach($budgets as $b) {
            if ($b->sub_bidang) {
                $chartAnggaran['labels'][] = $b->sub_bidang;
                $chartAnggaran['anggaran'][] = $b->total_anggaran / 1000000; // in millions
                $chartAnggaran['realisasi'][] = $b->total_realisasi / 1000000;
            }
        }

        $informasiTerbaru = \App\Models\FinanceInformation::where('status_publikasi', 'Rilis')
                            ->orderBy('created_at', 'desc')
                            ->limit(5)
                            ->get();
                            
        if (view()->exists('layanan.keuangan')) {
            return view('layanan.keuangan', compact('pajakTotal', 'chartAnggaran', 'informasiTerbaru', 'dept'));
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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/edit', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

// Admin Routes (protected)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('admin.users.index');
    Route::get('/users/create', [\App\Http\Controllers\AdminController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [\App\Http\Controllers\AdminController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{user}', [\App\Http\Controllers\AdminController::class, 'show'])->name('admin.users.show');
    Route::get('/users/{user}/edit', [\App\Http\Controllers\AdminController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [\App\Http\Controllers\AdminController::class, 'update'])->name('admin.users.update');
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

// Pembangunan Routes (protected)
Route::middleware('auth')->prefix('pembangunan')->group(function () {
    Route::get('/', [\App\Http\Controllers\PembangunanController::class, 'dashboard'])->name('pembangunan.dashboard');
    
    // Proyek Pembangunan
    Route::get('/project', [\App\Http\Controllers\PembangunanController::class, 'projectIndex'])->name('pembangunan.project.index');
    Route::get('/project/create', [\App\Http\Controllers\PembangunanController::class, 'projectCreate'])->name('pembangunan.project.create');
    Route::post('/project', [\App\Http\Controllers\PembangunanController::class, 'projectStore'])->name('pembangunan.project.store');
    Route::get('/project/{id}/edit', [\App\Http\Controllers\PembangunanController::class, 'projectEdit'])->name('pembangunan.project.edit');
    Route::put('/project/{id}', [\App\Http\Controllers\PembangunanController::class, 'projectUpdate'])->name('pembangunan.project.update');
    Route::delete('/project/{id}', [\App\Http\Controllers\PembangunanController::class, 'projectDestroy'])->name('pembangunan.project.destroy');

    // Dokumen Proyek
    Route::get('/document', [\App\Http\Controllers\PembangunanController::class, 'documentIndex'])->name('pembangunan.document.index');
    Route::get('/document/create', [\App\Http\Controllers\PembangunanController::class, 'documentCreate'])->name('pembangunan.document.create');
    Route::post('/document', [\App\Http\Controllers\PembangunanController::class, 'documentStore'])->name('pembangunan.document.store');
    Route::get('/document/{id}/edit', [\App\Http\Controllers\PembangunanController::class, 'documentEdit'])->name('pembangunan.document.edit');
    Route::put('/document/{id}', [\App\Http\Controllers\PembangunanController::class, 'documentUpdate'])->name('pembangunan.document.update');
    Route::delete('/document/{id}', [\App\Http\Controllers\PembangunanController::class, 'documentDestroy'])->name('pembangunan.document.destroy');
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

    // Informasi Terbaru
    Route::get('/informasi', [\App\Http\Controllers\KesehatanInformasiController::class, 'index'])->name('kesehatan.informasi.index');
    Route::post('/informasi', [\App\Http\Controllers\KesehatanInformasiController::class, 'store'])->name('kesehatan.informasi.store');
    Route::put('/informasi/{id}', [\App\Http\Controllers\KesehatanInformasiController::class, 'update'])->name('kesehatan.informasi.update');
    Route::delete('/informasi/{id}', [\App\Http\Controllers\KesehatanInformasiController::class, 'destroy'])->name('kesehatan.informasi.destroy');
});

// Keuangan Routes (protected)
Route::middleware('auth')->prefix('keuangan')->group(function () {
    Route::get('/', [\App\Http\Controllers\KeuanganController::class, 'dashboard'])->name('finance.dashboard');
    
    // Data Anggaran
    Route::get('/anggaran', [\App\Http\Controllers\FinanceBudgetController::class, 'index'])->name('finance.budget.index');
    Route::post('/anggaran', [\App\Http\Controllers\FinanceBudgetController::class, 'store'])->name('finance.budget.store');
    Route::get('/anggaran/{id}', [\App\Http\Controllers\FinanceBudgetController::class, 'show'])->name('finance.budget.show');
    Route::put('/anggaran/{id}', [\App\Http\Controllers\FinanceBudgetController::class, 'update'])->name('finance.budget.update');
    Route::delete('/anggaran/{id}', [\App\Http\Controllers\FinanceBudgetController::class, 'destroy'])->name('finance.budget.destroy');

    // Data PAD
    Route::get('/pad', [\App\Http\Controllers\FinancePadController::class, 'index'])->name('finance.pad.index');
    Route::post('/pad', [\App\Http\Controllers\FinancePadController::class, 'store'])->name('finance.pad.store');
    Route::get('/pad/{id}', [\App\Http\Controllers\FinancePadController::class, 'show'])->name('finance.pad.show');
    Route::put('/pad/{id}', [\App\Http\Controllers\FinancePadController::class, 'update'])->name('finance.pad.update');
    Route::delete('/pad/{id}', [\App\Http\Controllers\FinancePadController::class, 'destroy'])->name('finance.pad.destroy');

    // Data Pajak Daerah
    Route::get('/tax', [\App\Http\Controllers\FinanceTaxController::class, 'index'])->name('finance.tax.index');
    Route::post('/tax', [\App\Http\Controllers\FinanceTaxController::class, 'store'])->name('finance.tax.store');
    Route::get('/tax/{id}', [\App\Http\Controllers\FinanceTaxController::class, 'show'])->name('finance.tax.show');
    Route::put('/tax/{id}', [\App\Http\Controllers\FinanceTaxController::class, 'update'])->name('finance.tax.update');
    Route::delete('/tax/{id}', [\App\Http\Controllers\FinanceTaxController::class, 'destroy'])->name('finance.tax.destroy');

    // Sub Bidang / Unit Keuangan
    Route::get('/subbidang', [\App\Http\Controllers\FinanceSubBidangController::class, 'index'])->name('finance.subbidang.index');
    Route::post('/subbidang', [\App\Http\Controllers\FinanceSubBidangController::class, 'store'])->name('finance.subbidang.store');
    Route::get('/subbidang/{id}', [\App\Http\Controllers\FinanceSubBidangController::class, 'show'])->name('finance.subbidang.show');
    Route::put('/subbidang/{id}', [\App\Http\Controllers\FinanceSubBidangController::class, 'update'])->name('finance.subbidang.update');
    Route::delete('/subbidang/{id}', [\App\Http\Controllers\FinanceSubBidangController::class, 'destroy'])->name('finance.subbidang.destroy');

    // Informasi Terbaru
    Route::get('/information', [\App\Http\Controllers\FinanceInformationController::class, 'index'])->name('finance.information.index');
    Route::post('/information', [\App\Http\Controllers\FinanceInformationController::class, 'store'])->name('finance.information.store');
    Route::get('/information/{id}', [\App\Http\Controllers\FinanceInformationController::class, 'show'])->name('finance.information.show');
    Route::put('/information/{id}', [\App\Http\Controllers\FinanceInformationController::class, 'update'])->name('finance.information.update');
    Route::delete('/information/{id}', [\App\Http\Controllers\FinanceInformationController::class, 'destroy'])->name('finance.information.destroy');
});

// Kepegawaian Routes (protected)
Route::middleware('auth')->prefix('kepegawaian')->group(function () {
    Route::get('/', [\App\Http\Controllers\KepegawaianController::class, 'dashboard'])->name('kepegawaian.dashboard');
    
    // Data Pegawai
    Route::get('/data', [\App\Http\Controllers\PegawaiDataController::class, 'index'])->name('kepegawaian.data.index');
    Route::get('/data/create', [\App\Http\Controllers\PegawaiDataController::class, 'create'])->name('kepegawaian.data.create');
    Route::post('/data', [\App\Http\Controllers\PegawaiDataController::class, 'store'])->name('kepegawaian.data.store');
    Route::get('/data/{id}/edit', [\App\Http\Controllers\PegawaiDataController::class, 'edit'])->name('kepegawaian.data.edit');
    Route::get('/data/{id}', [\App\Http\Controllers\PegawaiDataController::class, 'show'])->name('kepegawaian.data.show');
    Route::put('/data/{id}', [\App\Http\Controllers\PegawaiDataController::class, 'update'])->name('kepegawaian.data.update');
    Route::delete('/data/{id}', [\App\Http\Controllers\PegawaiDataController::class, 'destroy'])->name('kepegawaian.data.destroy');

    // Jabatan & Unit Kerja
    Route::get('/jabatan', [\App\Http\Controllers\PegawaiJabatanController::class, 'index'])->name('kepegawaian.jabatan.index');
    Route::get('/jabatan/create', [\App\Http\Controllers\PegawaiJabatanController::class, 'create'])->name('kepegawaian.jabatan.create');
    Route::post('/jabatan', [\App\Http\Controllers\PegawaiJabatanController::class, 'store'])->name('kepegawaian.jabatan.store');
    Route::get('/jabatan/{id}/edit', [\App\Http\Controllers\PegawaiJabatanController::class, 'edit'])->name('kepegawaian.jabatan.edit');
    Route::get('/jabatan/{id}', [\App\Http\Controllers\PegawaiJabatanController::class, 'show'])->name('kepegawaian.jabatan.show');
    Route::put('/jabatan/{id}', [\App\Http\Controllers\PegawaiJabatanController::class, 'update'])->name('kepegawaian.jabatan.update');
    Route::delete('/jabatan/{id}', [\App\Http\Controllers\PegawaiJabatanController::class, 'destroy'])->name('kepegawaian.jabatan.destroy');

    // Mutasi & Pensiun
    Route::get('/mutasi', [\App\Http\Controllers\PegawaiMutasiController::class, 'index'])->name('kepegawaian.mutasi.index');
    Route::get('/mutasi/create', [\App\Http\Controllers\PegawaiMutasiController::class, 'create'])->name('kepegawaian.mutasi.create');
    Route::post('/mutasi', [\App\Http\Controllers\PegawaiMutasiController::class, 'store'])->name('kepegawaian.mutasi.store');
    Route::get('/mutasi/{id}/edit', [\App\Http\Controllers\PegawaiMutasiController::class, 'edit'])->name('kepegawaian.mutasi.edit');
    Route::get('/mutasi/{id}', [\App\Http\Controllers\PegawaiMutasiController::class, 'show'])->name('kepegawaian.mutasi.show');
    Route::put('/mutasi/{id}', [\App\Http\Controllers\PegawaiMutasiController::class, 'update'])->name('kepegawaian.mutasi.update');
    Route::delete('/mutasi/{id}', [\App\Http\Controllers\PegawaiMutasiController::class, 'destroy'])->name('kepegawaian.mutasi.destroy');

    // Informasi Terbaru
    Route::get('/informasi', [\App\Http\Controllers\PegawaiInformasiController::class, 'index'])->name('kepegawaian.informasi.index');
    Route::get('/informasi/create', [\App\Http\Controllers\PegawaiInformasiController::class, 'create'])->name('kepegawaian.informasi.create');
    Route::post('/informasi', [\App\Http\Controllers\PegawaiInformasiController::class, 'store'])->name('kepegawaian.informasi.store');
    Route::get('/informasi/{id}/edit', [\App\Http\Controllers\PegawaiInformasiController::class, 'edit'])->name('kepegawaian.informasi.edit');
    Route::get('/informasi/{id}', [\App\Http\Controllers\PegawaiInformasiController::class, 'show'])->name('kepegawaian.informasi.show');
    Route::put('/informasi/{id}', [\App\Http\Controllers\PegawaiInformasiController::class, 'update'])->name('kepegawaian.informasi.update');
    Route::delete('/informasi/{id}', [\App\Http\Controllers\PegawaiInformasiController::class, 'destroy'])->name('kepegawaian.informasi.destroy');
});

// Kependudukan Routes (protected)
Route::middleware('auth')->prefix('kependudukan')->group(function () {
    Route::get('/', [\App\Http\Controllers\KependudukanController::class, 'dashboard'])->name('kependudukan.dashboard');
    Route::get('/data-penduduk', [\App\Http\Controllers\KependudukanController::class, 'dataPendudukIndex'])->name('kependudukan.data-penduduk.index');
    Route::get('/data-penduduk/create', [\App\Http\Controllers\KependudukanController::class, 'dataPendudukCreate'])->name('kependudukan.data-penduduk.create');
    Route::post('/data-penduduk', [\App\Http\Controllers\KependudukanController::class, 'dataPendudukStore'])->name('kependudukan.data-penduduk.store');
    Route::get('/data-penduduk/{id}', [\App\Http\Controllers\KependudukanController::class, 'dataPendudukShow'])->name('kependudukan.data-penduduk.show');
    Route::get('/data-penduduk/{id}/edit', [\App\Http\Controllers\KependudukanController::class, 'dataPendudukEdit'])->name('kependudukan.data-penduduk.edit');
    Route::put('/data-penduduk/{id}', [\App\Http\Controllers\KependudukanController::class, 'dataPendudukUpdate'])->name('kependudukan.data-penduduk.update');
    Route::get('/data-agama', [\App\Http\Controllers\KependudukanController::class, 'dataAgamaIndex'])->name('kependudukan.data-agama.index');
    Route::get('/data-agama/create', [\App\Http\Controllers\KependudukanController::class, 'dataAgamaCreate'])->name('kependudukan.data-agama.create');
    Route::post('/data-agama', [\App\Http\Controllers\KependudukanController::class, 'dataAgamaStore'])->name('kependudukan.data-agama.store');
    Route::get('/data-agama/{id}', [\App\Http\Controllers\KependudukanController::class, 'dataAgamaShow'])->name('kependudukan.data-agama.show');
    Route::get('/data-agama/{id}/edit', [\App\Http\Controllers\KependudukanController::class, 'dataAgamaEdit'])->name('kependudukan.data-agama.edit');
    Route::put('/data-agama/{id}', [\App\Http\Controllers\KependudukanController::class, 'dataAgamaUpdate'])->name('kependudukan.data-agama.update');
    Route::delete('/data-agama/{id}', [\App\Http\Controllers\KependudukanController::class, 'dataAgamaDestroy'])->name('kependudukan.data-agama.destroy');
    Route::get('/data-wilayah', [\App\Http\Controllers\KependudukanController::class, 'dataWilayahIndex'])->name('kependudukan.data-wilayah.index');
    Route::get('/data-wilayah/create', [\App\Http\Controllers\KependudukanController::class, 'dataWilayahCreate'])->name('kependudukan.data-wilayah.create');
    Route::post('/data-wilayah', [\App\Http\Controllers\KependudukanController::class, 'dataWilayahStore'])->name('kependudukan.data-wilayah.store');
    Route::get('/data-wilayah/{id}', [\App\Http\Controllers\KependudukanController::class, 'dataWilayahShow'])->name('kependudukan.data-wilayah.show');
    Route::get('/data-wilayah/{id}/edit', [\App\Http\Controllers\KependudukanController::class, 'dataWilayahEdit'])->name('kependudukan.data-wilayah.edit');
    Route::put('/data-wilayah/{id}', [\App\Http\Controllers\KependudukanController::class, 'dataWilayahUpdate'])->name('kependudukan.data-wilayah.update');
    Route::delete('/data-wilayah/{id}', [\App\Http\Controllers\KependudukanController::class, 'dataWilayahDestroy'])->name('kependudukan.data-wilayah.destroy');
    Route::get('/data-kartu-keluarga', [\App\Http\Controllers\KependudukanController::class, 'dataKartuKeluargaIndex'])->name('kependudukan.data-kartu-keluarga.index');
    Route::get('/data-kartu-keluarga/create', [\App\Http\Controllers\KependudukanController::class, 'dataKartuKeluargaCreate'])->name('kependudukan.data-kartu-keluarga.create');
    Route::post('/data-kartu-keluarga', [\App\Http\Controllers\KependudukanController::class, 'dataKartuKeluargaStore'])->name('kependudukan.data-kartu-keluarga.store');
    Route::get('/data-kartu-keluarga/{id}', [\App\Http\Controllers\KependudukanController::class, 'dataKartuKeluargaShow'])->name('kependudukan.data-kartu-keluarga.show');
    Route::get('/data-kartu-keluarga/{id}/edit', [\App\Http\Controllers\KependudukanController::class, 'dataKartuKeluargaEdit'])->name('kependudukan.data-kartu-keluarga.edit');
    Route::put('/data-kartu-keluarga/{id}', [\App\Http\Controllers\KependudukanController::class, 'dataKartuKeluargaUpdate'])->name('kependudukan.data-kartu-keluarga.update');
    Route::delete('/data-kartu-keluarga/{id}', [\App\Http\Controllers\KependudukanController::class, 'dataKartuKeluargaDestroy'])->name('kependudukan.data-kartu-keluarga.destroy');
    Route::get('/mutasi-penduduk', [\App\Http\Controllers\KependudukanController::class, 'mutasiPendudukIndex'])->name('kependudukan.mutasi-penduduk.index');
    Route::get('/mutasi-penduduk/create', [\App\Http\Controllers\KependudukanController::class, 'mutasiPendudukCreate'])->name('kependudukan.mutasi-penduduk.create');
    Route::post('/mutasi-penduduk', [\App\Http\Controllers\KependudukanController::class, 'mutasiPendudukStore'])->name('kependudukan.mutasi-penduduk.store');
    Route::get('/mutasi-penduduk/{id}', [\App\Http\Controllers\KependudukanController::class, 'mutasiPendudukShow'])->name('kependudukan.mutasi-penduduk.show');
    Route::get('/mutasi-penduduk/{id}/edit', [\App\Http\Controllers\KependudukanController::class, 'mutasiPendudukEdit'])->name('kependudukan.mutasi-penduduk.edit');
    Route::put('/mutasi-penduduk/{id}', [\App\Http\Controllers\KependudukanController::class, 'mutasiPendudukUpdate'])->name('kependudukan.mutasi-penduduk.update');
    Route::delete('/mutasi-penduduk/{id}', [\App\Http\Controllers\KependudukanController::class, 'mutasiPendudukDestroy'])->name('kependudukan.mutasi-penduduk.destroy');
    Route::get('/informasi-terbaru', [\App\Http\Controllers\KependudukanController::class, 'informasiTerbaruIndex'])->name('kependudukan.informasi-terbaru.index');
    Route::get('/informasi-terbaru/create', [\App\Http\Controllers\KependudukanController::class, 'informasiTerbaruCreate'])->name('kependudukan.informasi-terbaru.create');
    Route::post('/informasi-terbaru', [\App\Http\Controllers\KependudukanController::class, 'informasiTerbaruStore'])->name('kependudukan.informasi-terbaru.store');
    Route::get('/informasi-terbaru/{id}/pdf', [\App\Http\Controllers\KependudukanController::class, 'informasiTerbaruPdf'])->name('kependudukan.informasi-terbaru.pdf');
    Route::get('/informasi-terbaru/{id}', [\App\Http\Controllers\KependudukanController::class, 'informasiTerbaruShow'])->name('kependudukan.informasi-terbaru.show');
    Route::get('/informasi-terbaru/{id}/edit', [\App\Http\Controllers\KependudukanController::class, 'informasiTerbaruEdit'])->name('kependudukan.informasi-terbaru.edit');
    Route::put('/informasi-terbaru/{id}', [\App\Http\Controllers\KependudukanController::class, 'informasiTerbaruUpdate'])->name('kependudukan.informasi-terbaru.update');
    Route::delete('/informasi-terbaru/{id}', [\App\Http\Controllers\KependudukanController::class, 'informasiTerbaruDestroy'])->name('kependudukan.informasi-terbaru.destroy');
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
