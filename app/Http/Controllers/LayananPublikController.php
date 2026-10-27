<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class LayananPublikController extends Controller
{
    public function index(Request $request)
    {
        $dept = $request->query('dept');
        $filters = $request->all(); // cache key variations
        $cacheKey = 'layanan_publik_' . $dept . '_' . md5(json_encode($filters));

        // Cache everything for 5 minutes (300 seconds)
        return Cache::remember($cacheKey, 300, function () use ($dept, $request) {
            
            if ($dept === 'perizinan') {
                $qData = \App\Models\PerizinanData::query();
                $tahunOptions = $this->distinctDateParts(\App\Models\PerizinanData::class, 'tanggal', 'year');
                $jenisOptions = \App\Models\PerizinanData::distinct()->pluck('jenis_permohonan')->filter()->toArray();
                $statusOptions = \App\Models\PerizinanData::distinct()->pluck('status')->filter()->toArray();
                
                $filters = $request->only(['tahun', 'jenis_izin', 'status']);
                if (!empty($filters['tahun'])) $qData->whereYear('tanggal', $filters['tahun']);
                if (!empty($filters['jenis_izin'])) $qData->where('jenis_permohonan', $filters['jenis_izin']);
                if (!empty($filters['status'])) $qData->where('status', $filters['status']);

                $dataPerizinan = (clone $qData)->with('jenisIzin')->orderBy('created_at', 'desc')->limit(10)->get();
                $publikasi = \App\Models\PerizinanPublikasi::where('status', 'Aktif')->orderBy('created_at', 'desc')->get();
                
                $stats = [
                    'total' => (clone $qData)->count(),
                    'disetujui' => (clone $qData)->where('status', 'Disetujui')->count(),
                    'proses' => (clone $qData)->where('status', 'Proses')->count(),
                    'ditolak' => (clone $qData)->where('status', 'Ditolak')->count(),
                    'baru' => (clone $qData)->where('jenis_permohonan', 'Baru')->count(),
                    'perpanjangan' => (clone $qData)->where('jenis_permohonan', 'Perpanjangan')->count(),
                    'lainnya' => (clone $qData)->whereNotIn('jenis_permohonan', ['Baru', 'Perpanjangan'])->count(),
                ];
                
                $currentYear = !empty($filters['tahun']) ? $filters['tahun'] : date('Y');
                $monthlyData = (clone $qData)->whereYear('tanggal', $currentYear)->get(['tanggal', 'status']);
                                    
                $chartData = [
                    'total_bulanan' => array_fill(1, 12, 0),
                    'disetujui_bulanan' => array_fill(1, 12, 0),
                    'proses_bulanan' => array_fill(1, 12, 0)
                ];
                
                foreach ($monthlyData as $row) {
                    $month = Carbon::parse($row->tanggal)->month;
                    $chartData['total_bulanan'][$month]++;
                    if ($row->status == 'Disetujui') {
                        $chartData['disetujui_bulanan'][$month]++;
                    } elseif ($row->status == 'Proses') {
                        $chartData['proses_bulanan'][$month]++;
                    }
                }
                
                if (view()->exists('layanan.perizinan')) return view('layanan.perizinan', compact('dataPerizinan', 'publikasi', 'dept', 'stats', 'chartData', 'tahunOptions', 'jenisOptions', 'statusOptions', 'filters'))->render();
            }
            
            if ($dept === 'kepegawaian') {
                $qPegawai = \App\Models\PegawaiData::query();
                $qMutasi = \App\Models\PegawaiMutasi::query();
                
                $unitKerjaOptions = \App\Models\PegawaiData::distinct()->pluck('unit_kerja')->filter()->toArray();
                $golonganOptions = \App\Models\PegawaiData::distinct()->pluck('golongan')->filter()->toArray();
                $statusOptions = \App\Models\PegawaiData::distinct()->pluck('jenis_pegawai')->filter()->toArray();
                
                $filters = $request->only(['unit_kerja', 'golongan', 'status']);
                if (!empty($filters['unit_kerja'])) $qPegawai->where('unit_kerja', $filters['unit_kerja']);
                if (!empty($filters['golongan'])) $qPegawai->where('golongan', $filters['golongan']);
                if (!empty($filters['status'])) $qPegawai->where('jenis_pegawai', $filters['status']);

                $stats = [
                    'total' => (clone $qPegawai)->count(),
                    'pns' => (clone $qPegawai)->where('jenis_pegawai', 'PNS')->count(),
                    'pppk' => (clone $qPegawai)->where('jenis_pegawai', 'PPPK')->count(),
                    'non_asn' => (clone $qPegawai)->where('jenis_pegawai', 'Non-ASN')->count(),
                ];
                
                $unitKerjaRaw = (clone $qPegawai)->selectRaw('unit_kerja, count(*) as total')->groupBy('unit_kerja')->get();
                $chartUnitKerja = ['labels' => [], 'data' => []];
                foreach($unitKerjaRaw as $u) {
                    $chartUnitKerja['labels'][] = $u->unit_kerja ?? 'Lainnya';
                    $chartUnitKerja['data'][] = $u->total;
                }

                $genderRaw = (clone $qPegawai)->selectRaw('jenis_kelamin, count(*) as total')->groupBy('jenis_kelamin')->get();
                $chartGender = ['Laki-laki' => 0, 'Perempuan' => 0];
                foreach($genderRaw as $g) {
                    if ($g->jenis_kelamin == 'Laki-laki' || $g->jenis_kelamin == 'L') $chartGender['Laki-laki'] += $g->total;
                    else $chartGender['Perempuan'] += $g->total;
                }

                $golonganRaw = (clone $qPegawai)->selectRaw('golongan, count(*) as total')->groupBy('golongan')->get();
                $chartGolongan = ['labels' => [], 'data' => []];
                foreach($golonganRaw as $g) {
                    if ($g->golongan) {
                        $chartGolongan['labels'][] = $g->golongan;
                        $chartGolongan['data'][] = $g->total;
                    }
                }

                $mutasiRaw = \App\Models\PegawaiMutasi::whereYear('tanggal_efektif', date('Y'))->get(['tanggal_efektif']);
                $chartMutasi = array_fill(1, 12, 0);
                foreach($mutasiRaw as $m) {
                    $chartMutasi[Carbon::parse($m->tanggal_efektif)->month]++;
                }

                $informasiTerbaru = \App\Models\PegawaiInformasi::where('status_publikasi', 'Rilis')->orderBy('created_at', 'desc')->limit(3)->get();
                $tabelRingkas = \App\Models\PegawaiMutasi::orderBy('tanggal_efektif', 'desc')->limit(5)->get();

                if (view()->exists('layanan.kepegawaian')) return view('layanan.kepegawaian', compact('stats', 'chartUnitKerja', 'chartGender', 'chartGolongan', 'chartMutasi', 'informasiTerbaru', 'tabelRingkas', 'dept', 'unitKerjaOptions', 'golonganOptions', 'statusOptions', 'filters'))->render();
            }

            if ($dept === 'keuangan') {
                $qBudget = \App\Models\FinanceBudget::query();
                $qPad = \App\Models\FinancePad::query();
                $qTax = \App\Models\FinanceTax::query();
                
                $tahunOptions = \App\Models\FinanceBudget::distinct()->pluck('tahun')->filter()->toArray();
                $sektorOptions = \App\Models\FinanceBudget::distinct()->pluck('sub_bidang')->filter()->toArray();
                
                $filters = $request->only(['tahun', 'sektor', 'search']);
                if (!empty($filters['tahun'])) {
                    $qBudget->where('tahun', $filters['tahun']);
                    $qPad->where('tahun', $filters['tahun']);
                }
                if (!empty($filters['sektor'])) {
                    $qBudget->where('sub_bidang', $filters['sektor']);
                    $qPad->where('sub_bidang', $filters['sektor']);
                }
                
                if (!empty($filters['tahun'])) {
                    $qTax->where('tahun', $filters['tahun']);
                }
                if (!empty($filters['search'])) {
                    $search = $filters['search'];
                    $qBudget->where(fn($query) => $query->where('nama_anggaran', 'like', '%' . $search . '%')
                        ->orWhere('sub_bidang', 'like', '%' . $search . '%'));
                    $qPad->where(fn($query) => $query->where('sumber_pendapatan', 'like', '%' . $search . '%')
                        ->orWhere('sub_bidang', 'like', '%' . $search . '%'));
                    $qTax->where('jenis_pajak', 'like', '%' . $search . '%');
                }

                $totalAnggaran = (clone $qBudget)->sum('total_anggaran');
                $totalRealisasi = (clone $qBudget)->sum('total_realisasi');
                $persentaseRealisasi = $totalAnggaran > 0 ? round(($totalRealisasi / $totalAnggaran) * 100, 1) : null;
                $totalPad = (clone $qPad)->sum('realisasi_pad');
                $totalPajak = (clone $qTax)->sum('jumlah_pendapatan');
                $lastUpdatedAt = collect([
                    (clone $qBudget)->max('updated_at'),
                    (clone $qPad)->max('updated_at'),
                    (clone $qTax)->max('updated_at'),
                ])->filter()->max();

                $stats = [
                    'total_anggaran' => $totalAnggaran,
                    'total_realisasi' => $totalRealisasi,
                    'persentase_realisasi' => $persentaseRealisasi,
                    'pad' => $totalPad,
                    'pajak' => $totalPajak,
                    'update_terakhir' => $lastUpdatedAt ? Carbon::parse($lastUpdatedAt)->timezone('Asia/Jakarta')->format('d M Y') : null,
                    'has_budget_data' => (clone $qBudget)->exists(),
                    'has_pad_data' => (clone $qPad)->exists(),
                    'has_tax_data' => (clone $qTax)->exists(),
                ];

                $budgets = (clone $qBudget)->selectRaw('tahun, sub_bidang, nama_anggaran, SUM(total_anggaran) as total_anggaran, SUM(total_realisasi) as total_realisasi')
                    ->groupBy('tahun', 'sub_bidang', 'nama_anggaran')
                    ->get();

                $chartAnggaran = [
                    'labels' => $budgets->pluck('sub_bidang')->unique()->values()->toArray(),
                    'anggaran' => $budgets->groupBy('sub_bidang')->map(fn($items) => round($items->sum('total_anggaran') / 1000000000, 1))->values()->toArray(),
                    'realisasi' => $budgets->groupBy('sub_bidang')->map(fn($items) => round($items->sum('total_realisasi') / 1000000000, 1))->values()->toArray(),
                ];

                $trend = (clone $qBudget)->selectRaw('tahun, periode, SUM(total_realisasi) as total_realisasi')
                    ->groupBy('tahun', 'periode')
                    ->orderBy('tahun')
                    ->orderBy('periode')
                    ->get();
                $chartTrend = [
                    'labels' => $trend->map(fn($item) => trim(($item->periode ?? '') . ' ' . $item->tahun))->toArray(),
                    'data' => $trend->map(fn($item) => round($item->total_realisasi / 1000000000, 1))->toArray(),
                ];

                // 3. Grafik Pendapatan Asli Daerah (PAD per Sektor)
                $pads = (clone $qPad)->selectRaw('sumber_pendapatan, SUM(target_pad) as total_target, SUM(realisasi_pad) as total_realisasi')
                    ->groupBy('sumber_pendapatan')
                    ->get();

                $chartPAD = [
                    'labels' => $pads->pluck('sumber_pendapatan')->toArray(),
                    'target' => $pads->map(fn($pad) => round($pad->total_target / 1000000000, 1))->toArray(),
                    'realisasi' => $pads->map(fn($pad) => round($pad->total_realisasi / 1000000000, 1))->toArray(),
                ];

                // Tax records contain realized revenue only, not a verified target.
                $taxes = (clone $qTax)->selectRaw('jenis_pajak, SUM(jumlah_pendapatan) as total_pendapatan')
                    ->groupBy('jenis_pajak')
                    ->get();
                $chartPajak = [
                    'labels' => $taxes->pluck('jenis_pajak')->toArray(),
                    'realisasi' => $taxes->map(fn($tax) => round($tax->total_pendapatan / 1000000, 0))->toArray(),
                ];

                $tabelKeuangan = $budgets->map(function ($budget) {
                    $percentage = (float) $budget->total_anggaran > 0
                        ? round(((float) $budget->total_realisasi / (float) $budget->total_anggaran) * 100, 1)
                        : null;

                    return [
                        'tahun' => $budget->tahun,
                        'kategori' => $budget->nama_anggaran,
                        'unit' => $budget->sub_bidang,
                        'anggaran' => 'Rp' . number_format((float) $budget->total_anggaran, 0, ',', '.'),
                        'realisasi' => 'Rp' . number_format((float) $budget->total_realisasi, 0, ',', '.'),
                        'persentase' => $percentage === null ? 'Belum tersedia' : number_format($percentage, 1, ',', '.') . '%',
                        'keterangan' => $budget->status ?? 'Tercatat',
                        'badge' => 'success',
                    ];
                });

                // Informasi Dokumen Publikasi
                $informasiTerbaru = \App\Models\FinanceInformation::where('status_publikasi', 'Rilis')->orderBy('created_at', 'desc')->limit(5)->get();

                if (view()->exists('layanan.keuangan')) {
                    return view('layanan.keuangan', compact('stats', 'chartAnggaran', 'chartTrend', 'chartPAD', 'chartPajak', 'tabelKeuangan', 'informasiTerbaru', 'dept', 'tahunOptions', 'sektorOptions', 'filters'))->render();
                }
            }

            if ($dept === 'pembangunan') {
                $qProject = \App\Models\PembangunanProject::query();
                
                $kecamatanOptions = \App\Models\PembangunanProject::distinct()->pluck('kecamatan')->filter()->toArray();
                $kategoriOptions = \App\Models\PembangunanProject::distinct()->pluck('category')->filter()->toArray();
                $statusOptions = \App\Models\PembangunanProject::distinct()->pluck('status')->filter()->toArray();
                $tahunOptions = $this->distinctDateParts(\App\Models\PembangunanProject::class, 'created_at', 'year');

                $filters = $request->only(['kecamatan', 'kategori', 'status', 'tahun']);
                if (!empty($filters['kecamatan'])) $qProject->where('kecamatan', $filters['kecamatan']);
                if (!empty($filters['kategori'])) $qProject->where('category', $filters['kategori']);
                if (!empty($filters['status'])) $qProject->where('status', $filters['status']);
                if (!empty($filters['tahun'])) $qProject->whereYear('created_at', $filters['tahun']);

                $stats = [
                    'total' => (clone $qProject)->count(),
                    'selesai' => (clone $qProject)->where('status', 'Selesai')->count(),
                    'berjalan' => (clone $qProject)->where('status', 'Berjalan')->count(),
                    'anggaran' => (clone $qProject)->sum('total_budget')
                ];
                
                $projects = (clone $qProject)->orderBy('created_at', 'desc')->limit(6)->get();
                
                // Optimized spatial query: only fetch specific columns
                $mapData = (clone $qProject)->select('name', 'latitude', 'longitude', 'status', 'progress_percentage')
                            ->whereNotNull('latitude')->whereNotNull('longitude')
                            ->get()->map(function($p) {
                    return [
                        'name' => $p->name,
                        'lat' => $p->latitude,
                        'lng' => $p->longitude,
                        'status' => $p->status,
                        'progress' => $p->progress_percentage
                    ];
                })->values();

                $dokumentasi = \App\Models\PembangunanDocument::with('project')->where('type', 'Image')->orderBy('upload_date', 'desc')->limit(4)->get();

                if (view()->exists('layanan.pembangunan')) return view('layanan.pembangunan', compact('stats', 'projects', 'mapData', 'dokumentasi', 'dept', 'kecamatanOptions', 'kategoriOptions', 'statusOptions', 'tahunOptions', 'filters'))->render();
            }

            if ($dept === 'kesehatan') {
                $queryPenyakit = \App\Models\KesehatanPenyakit::query();

                $tahunOptions = \App\Models\KesehatanPenyakit::query()->distinct()->orderByDesc('tahun')->pluck('tahun');
                $wilayahOptions = \App\Models\KesehatanPenyakit::query()->distinct()->orderBy('wilayah')->pluck('wilayah');

                if ($request->filled('tahun')) {
                    $queryPenyakit->where('tahun', $request->input('tahun'));
                }
                if ($request->filled('wilayah')) {
                    $queryPenyakit->where('wilayah', $request->input('wilayah'));
                }
                if ($request->filled('keyword')) {
                    $keyword = $request->input('keyword');
                    $queryPenyakit->where(function($q) use ($keyword) {
                        $q->where('nama', 'like', "%{$keyword}%")
                          ->orWhere('wilayah', 'like', "%{$keyword}%")
                          ->orWhere('bulan', 'like', "%{$keyword}%");
                    });
                }

                $informasi = \App\Models\KesehatanInformasi::orderBy('created_at', 'desc')->limit(5)->get();
                $penyakit = (clone $queryPenyakit)->orderBy('jumlah', 'desc')->limit(5)->get();
                $hasHealthCaseData = (clone $queryPenyakit)->exists();

                $stats = [
                    'total' => \App\Models\KesehatanInformasi::count(),
                    'pasien' => $hasHealthCaseData ? (clone $queryPenyakit)->sum('jumlah') : null,
                    'kasus' => $hasHealthCaseData ? (clone $queryPenyakit)->where('status', 'Aktif')->sum('jumlah') : null,
                    'vaksinasi' => null,
                    'pencegahan_stunting' => null,
                    'kartu_sehat' => null,
                ];

                // Tren Pasien Per Bulan (dari data real penyakit di database)
                $bulanList = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
                $bulanMap = [
                    'januari' => 0, 'jan' => 0,
                    'februari' => 1, 'feb' => 1,
                    'maret' => 2, 'mar' => 2,
                    'april' => 3, 'apr' => 3,
                    'mei' => 4, 'may' => 4,
                    'juni' => 5, 'jun' => 5,
                    'juli' => 6, 'jul' => 6,
                    'agustus' => 7, 'agu' => 7, 'aug' => 7,
                    'september' => 8, 'sep' => 8,
                    'oktober' => 9, 'okt' => 9, 'oct' => 9,
                    'november' => 10, 'nov' => 10,
                    'desember' => 11, 'des' => 11, 'dec' => 11
                ];
                $trenBulanan = array_fill(0, 12, 0);
                $penyakitBulanan = (clone $queryPenyakit)->selectRaw('bulan, SUM(jumlah) as total')
                    ->groupBy('bulan')->get();
                foreach ($penyakitBulanan as $row) {
                    $key = strtolower(trim($row->bulan));
                    if (isset($bulanMap[$key])) {
                        $trenBulanan[$bulanMap[$key]] += (int) $row->total;
                    }
                }

                // Kasus per wilayah (donut chart) dari data real di database
                $kasusWilayah = (clone $queryPenyakit)->where('status', 'Aktif')->selectRaw('wilayah, SUM(jumlah) as total')
                    ->groupBy('wilayah')->orderByDesc('total')->limit(4)->get();

                if (view()->exists('layanan.kesehatan')) {
                    return view('layanan.kesehatan', compact('informasi', 'penyakit', 'stats', 'dept', 'bulanList', 'trenBulanan', 'kasusWilayah', 'tahunOptions', 'wilayahOptions', 'hasHealthCaseData'))->render();
                }
            }

            if ($dept === 'perhubungan') {
                $qKir = \App\Models\UjiKir::query();
                
                $jenisOptions = \App\Models\UjiKir::distinct()->pluck('jenis_kendaraan')->filter()->toArray();
                $statusOptions = \App\Models\UjiKir::distinct()->pluck('status_uji')->filter()->toArray();
                $bulanOptions = $this->distinctDateParts(\App\Models\UjiKir::class, 'tanggal_uji', 'month');

                $filters = $request->only(['jenis_kendaraan', 'status_uji', 'bulan']);
                if (!empty($filters['jenis_kendaraan'])) $qKir->where('jenis_kendaraan', $filters['jenis_kendaraan']);
                if (!empty($filters['status_uji'])) $qKir->where('status_uji', $filters['status_uji']);
                if (!empty($filters['bulan'])) $qKir->whereMonth('tanggal_uji', $filters['bulan']);

                $stats = [
                    'total' => (clone $qKir)->count(),
                    'lulus' => (clone $qKir)->where('status_uji', 'Lulus Uji')->count(),
                    'tidak_lulus' => (clone $qKir)->where('status_uji', 'Tidak Lulus')->count(),
                    'uji_ulang' => (clone $qKir)->where('status_uji', 'Perlu Uji Ulang')->count(),
                ];
                
                $statsPerhubungan = [
                    ['label' => 'Total KIR Kendaraan', 'value' => number_format($stats['total']) . ' Unit'],
                    ['label' => 'Lulus Uji', 'value' => number_format($stats['lulus']) . ' Unit'],
                    ['label' => 'Tidak Lulus', 'value' => number_format($stats['tidak_lulus']) . ' Unit'],
                    ['label' => 'Perlu Uji Ulang', 'value' => number_format($stats['uji_ulang']) . ' Unit'],
                ];

                $tabelKIRRaw = (clone $qKir)->orderBy('tanggal_uji', 'desc')->limit(5)->get();
                $tabelKIR = $tabelKIRRaw->map(function($row) {
                    return [
                        'bulan_tahun' => Carbon::parse($row->tanggal_uji)->format('M Y'),
                        'jenis_kendaraan' => $row->jenis_kendaraan,
                        'total_ukir' => '1 Unit',
                        'lulus_uji' => $row->status_uji == 'Lulus Uji' ? '1' : '0',
                        'tidak_lulus' => $row->status_uji == 'Tidak Lulus' ? '1' : '0',
                        'perlu_uji_ulang' => $row->status_uji == 'Perlu Uji Ulang' ? '1' : '0',
                        'keterangan' => $row->keterangan,
                        'badge' => 'bg-emerald-100 text-emerald-700'
                    ];
                });

                $informasiRaw = \App\Models\DokumenPerhubungan::orderBy('tanggal_rilis', 'desc')->limit(4)->get();
                $infoTerbaru = $informasiRaw->map(function($info) {
                    return [
                        'judul' => $info->judul,
                        'kategori' => $info->status_tag,
                        'tanggal' => Carbon::parse($info->tanggal_rilis)->format('d M Y'),
                        'status' => 'Rilis',
                        'badge' => 'bg-emerald-100 text-emerald-700',
                        'file_path' => $info->file_path
                    ];
                });
                
                if (view()->exists('layanan.perhubungan')) return view('layanan.perhubungan', compact('statsPerhubungan', 'tabelKIR', 'infoTerbaru', 'dept', 'jenisOptions', 'statusOptions', 'bulanOptions', 'filters'))->render();
            }

            if ($dept === 'sig') {
                $qSpasial = \App\Models\DataSpasial::whereHas('layer', fn($query) => $query->where('status_aktif', true));
                
                $kecamatanOptions = (clone $qSpasial)->distinct()->pluck('wilayah')->filter()->toArray();
                $kategoriOptions = (clone $qSpasial)->distinct()->pluck('kategori')->filter()->toArray();
                $tahunOptions = (clone $qSpasial)->whereNotNull('created_at')->pluck('created_at')
                    ->map(fn($date) => (int) Carbon::parse($date)->format('Y'))
                    ->unique()
                    ->sortDesc()
                    ->values()
                    ->all();
                
                $filters = $request->only(['kecamatan', 'kategori', 'tahun', 'search']);
                if (!empty($filters['kecamatan'])) $qSpasial->where('wilayah', $filters['kecamatan']);
                if (!empty($filters['kategori'])) $qSpasial->where('kategori', $filters['kategori']);
                if (!empty($filters['tahun'])) $qSpasial->whereYear('created_at', $filters['tahun']);
                if (!empty($filters['search'])) $qSpasial->where('nama_data', 'like', '%' . $filters['search'] . '%');

                $layerPublik = \App\Models\LayerSig::where('status_aktif', true)->orderBy('nama_layer')->get(['id', 'nama_layer']);
                $statsSIG = (clone $qSpasial)->selectRaw('kategori, SUM(nilai_jumlah) as total')
                    ->groupBy('kategori')
                    ->orderBy('kategori')
                    ->get()
                    ->map(fn($stat) => ['label' => $stat->kategori, 'value' => $stat->total]);
                $mapData = (clone $qSpasial)->whereNotNull('latitude')->whereNotNull('longitude')
                    ->get(['layer_id', 'nama_data', 'latitude', 'longitude']);

                $tabelSIGRaw = (clone $qSpasial)->with('layer')->orderBy('created_at', 'desc')->limit(10)->get();
                $tabelSIG = $tabelSIGRaw->map(function($row) {
                    return [
                        'nama_data' => $row->nama_data,
                        'kategori' => $row->kategori,
                        'wilayah' => $row->wilayah,
                        'nilai_jumlah' => $row->nilai_jumlah . ' Titik',
                        'update_terakhir' => Carbon::parse($row->updated_at)->format('d M Y')
                    ];
                });

                $informasiRaw = \App\Models\DokumenSig::where('status_tag', 'Rilis')->orderBy('tanggal_rilis', 'desc')->limit(4)->get();
                $infoTerbaruSIG = $informasiRaw->map(function($info) {
                    return [
                        'judul' => $info->judul,
                        'kategori' => $info->status_tag,
                        'tanggal' => Carbon::parse($info->tanggal_rilis)->format('d M Y'),
                        'status' => str_contains(strtolower($info->status_tag), 'draft') ? 'Draft' : 'Rilis',
                        'badge' => str_contains(strtolower($info->status_tag), 'draft') ? 'warning' : 'success',
                        'file_path' => $info->file_path
                    ];
                });
                
                if (view()->exists('layanan.sig')) return view('layanan.sig', compact('statsSIG', 'layerPublik', 'mapData', 'tabelSIG', 'infoTerbaruSIG', 'dept', 'kecamatanOptions', 'kategoriOptions', 'tahunOptions', 'filters'))->render();
            }

            if ($dept === 'kependudukan') {
                $queryPenduduk = \App\Models\KependudukanPenduduk::query();
                $queryAgama = \App\Models\KependudukanAgama::query();
                $queryMutasi = \App\Models\KependudukanMutasi::query();
                
                $wilayahOptions = \App\Models\KependudukanPenduduk::query()
                    ->select('kecamatan', 'kelurahan')
                    ->distinct()
                    ->orderBy('kecamatan')
                    ->orderBy('kelurahan')
                    ->get()
                    ->groupBy('kecamatan');
                $kecamatanOptions = $wilayahOptions->keys()->all();
                $kelurahanByKecamatan = $wilayahOptions
                    ->map(fn ($kelurahan) => $kelurahan->pluck('kelurahan')->values()->all())
                    ->all();
                $kelurahanOptions = \App\Models\KependudukanPenduduk::distinct()
                    ->orderBy('kelurahan')
                    ->pluck('kelurahan')
                    ->filter()
                    ->values()
                    ->all();
                $tahunOptions = \App\Models\KependudukanPenduduk::distinct()
                    ->orderByDesc('tahun')
                    ->pluck('tahun')
                    ->filter()
                    ->values()
                    ->all();
                $agamaOptions = \App\Models\KependudukanPenduduk::distinct()
                    ->orderBy('agama')
                    ->pluck('agama')
                    ->filter()
                    ->values()
                    ->all();
                $statusOptions = ['Aktif', 'Nonaktif'];
                
                $filters = $request->only(['kecamatan', 'kelurahan', 'tahun', 'agama', 'status']);
                $filters['status'] = $filters['status'] ?? 'Aktif';

                if (!empty($filters['kecamatan'])) {
                    $queryPenduduk->where('kecamatan', $filters['kecamatan']);
                    $queryAgama->where('kecamatan', $filters['kecamatan']);
                    $queryMutasi->where('kecamatan', $filters['kecamatan']);
                }
                if (!empty($filters['kelurahan'])) {
                    $queryPenduduk->where('kelurahan', $filters['kelurahan']);
                    $queryAgama->where('kelurahan', $filters['kelurahan']);
                    $queryMutasi->where('kelurahan', $filters['kelurahan']);
                }
                if (!empty($filters['tahun'])) {
                    $queryPenduduk->where('tahun', $filters['tahun']);
                    $queryAgama->where('tahun', $filters['tahun']);
                    $queryMutasi->where('tahun', $filters['tahun']);
                }
                if (!empty($filters['status'])) {
                    $queryPenduduk->where('status', $filters['status']);
                    $queryAgama->where('status', $filters['status']);
                    $queryMutasi->where('status', $filters['status']);
                }
                if (!empty($filters['agama'])) {
                    $queryPenduduk->where('agama', $filters['agama']);
                    $queryAgama->where('agama', $filters['agama']);
                }

                $stats = [
                    'totalPenduduk' => (clone $queryPenduduk)->sum('penduduk'),
                    'lakiLaki' => (clone $queryPenduduk)->sum('laki_laki'),
                    'perempuan' => (clone $queryPenduduk)->sum('perempuan'),
                    'totalKk' => (clone $queryPenduduk)->sum('kk'),
                    'wajibKtp' => (clone $queryPenduduk)->sum('wajib_ktp'),
                    'usiaProduktif' => (clone $queryPenduduk)->sum('usia_produktif'),
                    'kelahiranTahunIni' => (clone $queryMutasi)
                        ->where('tahun', $filters['tahun'] ?? now()->year)
                        ->sum('kelahiran'),
                    'kematianTahunIni' => (clone $queryMutasi)
                        ->where('tahun', $filters['tahun'] ?? now()->year)
                        ->sum('kematian'),
                ];
                
                $chartAgamaLabels = [];
                $chartAgamaData = [];
                $agamaGroups = (clone $queryAgama)
                                ->selectRaw('agama, SUM(penduduk) as total')
                                ->groupBy('agama')->get();
                foreach($agamaGroups as $g) {
                    if($g->agama) { $chartAgamaLabels[] = $g->agama; $chartAgamaData[] = $g->total; }
                }
                
                $chartGenderLabels = ['Laki-laki', 'Perempuan'];
                $chartGenderData = [$stats['lakiLaki'], $stats['perempuan']];
                
                $chartKecamatanLabels = [];
                $chartKecamatanData = [];
                $kecGroups = (clone $queryPenduduk)->selectRaw('kecamatan, SUM(penduduk) as total')->groupBy('kecamatan')->get();
                foreach($kecGroups as $g) {
                    if($g->kecamatan) { $chartKecamatanLabels[] = $g->kecamatan; $chartKecamatanData[] = $g->total; }
                }
                
                $chartKelurahanLabels = [];
                $chartKelurahanData = [];
                $kelGroups = (clone $queryPenduduk)->selectRaw('kelurahan, SUM(penduduk) as total')->groupBy('kelurahan')->orderByDesc('total')->get();
                foreach($kelGroups as $g) {
                    if($g->kelurahan) { $chartKelurahanLabels[] = $g->kelurahan; $chartKelurahanData[] = $g->total; }
                }
                
                $informasiTerbaru = \App\Models\KependudukanInformasi::where('status', 'Rilis')
                    ->orderByDesc('tanggal')
                    ->orderByDesc('id')
                    ->limit(4)
                    ->get();
                
                $filteredPenduduk = (clone $queryPenduduk)
                    ->orderByDesc('tahun')
                    ->orderBy('kecamatan')
                    ->orderBy('kelurahan')
                    ->paginate(25)
                    ->withQueryString();
                $dataPenduduk = $filteredPenduduk;
                
                if (view()->exists('layanan.kependudukan')) {
                    return view('layanan.kependudukan', compact(
                        'stats', 'filteredPenduduk', 'dataPenduduk', 'chartAgamaLabels', 'chartAgamaData',
                        'chartGenderLabels', 'chartGenderData', 'chartKecamatanLabels', 'chartKecamatanData',
                        'chartKelurahanLabels', 'chartKelurahanData', 'informasiTerbaru', 'kecamatanOptions',
                        'kelurahanOptions', 'kelurahanByKecamatan', 'tahunOptions', 'agamaOptions', 'statusOptions',
                        'filters', 'dept'
                    ))->render();
                }
            }

            // Fallback
            if ($dept && view()->exists("layanan.{$dept}")) return view("layanan.{$dept}")->render();
            return view('layanan', ['dept' => $dept])->render();
        });
    }

    private function distinctDateParts(string $model, string $column, string $part): array
    {
        $format = $part === 'year' ? 'Y' : 'n';

        return $model::query()->whereNotNull($column)->pluck($column)
            ->map(fn ($date) => (int) Carbon::parse($date)->format($format))
            ->unique()
            ->sort()
            ->values()
            ->all();
    }
}
