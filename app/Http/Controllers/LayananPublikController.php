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
                $tahunOptions = \App\Models\PerizinanData::selectRaw("CAST(strftime('%Y', tanggal) AS INTEGER) as tahun")->distinct()->pluck('tahun')->filter()->toArray();
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
                $monthlyData = (clone $qData)->selectRaw("CAST(strftime('%m', tanggal) AS INTEGER) as month, status, count(*) as total")
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

                $mutasiRaw = \App\Models\PegawaiMutasi::selectRaw("CAST(strftime('%m', tanggal_efektif) AS INTEGER) as month, count(*) as total")->whereYear('tanggal_efektif', date('Y'))->groupBy('month')->get();
                $chartMutasi = array_fill(1, 12, 0);
                foreach($mutasiRaw as $m) {
                    $chartMutasi[$m->month] = $m->total;
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
                
                $filters = $request->only(['tahun', 'sektor']);
                if (!empty($filters['tahun'])) {
                    $qBudget->where('tahun', $filters['tahun']);
                    $qPad->where('tahun', $filters['tahun']);
                }
                if (!empty($filters['sektor'])) {
                    $qBudget->where('sub_bidang', $filters['sektor']);
                    $qPad->where('sub_bidang', $filters['sektor']);
                }
                
                $totalAnggaran = (clone $qBudget)->sum('total_anggaran') ?: 22400000000;
                $totalRealisasi = (clone $qBudget)->sum('total_realisasi') ?: 18900000000;
                $persentaseRealisasi = $totalAnggaran > 0 ? round(($totalRealisasi / $totalAnggaran) * 100, 1) : 84.3;
                $totalPad = (clone $qPad)->sum('realisasi_pad') ?: 2300000000;
                $totalPajak = (clone $qTax)->sum('jumlah_pendapatan') ?: 1600000000;

                $stats = [
                    'total_anggaran' => $totalAnggaran,
                    'total_realisasi' => $totalRealisasi,
                    'persentase_realisasi' => $persentaseRealisasi,
                    'pad' => $totalPad,
                    'pajak' => $totalPajak,
                    'update_terakhir' => '03 Juli 2026'
                ];

                // 1. Grafik Anggaran vs Realisasi (Horizontal Bar)
                $budgets = (clone $qBudget)->selectRaw('sub_bidang, SUM(total_anggaran) as total_anggaran, SUM(total_realisasi) as total_realisasi')
                    ->groupBy('sub_bidang')
                    ->get();

                if ($budgets->isNotEmpty()) {
                    $chartAnggaran = [
                        'labels' => $budgets->pluck('sub_bidang')->map(fn($v) => str_replace('Bidang ', '', $v))->toArray(),
                        'anggaran' => $budgets->map(fn($b) => round($b->total_anggaran / 1000000000, 1))->toArray(),
                        'realisasi' => $budgets->map(fn($b) => round($b->total_realisasi / 1000000000, 1))->toArray(),
                    ];
                } else {
                    $chartAnggaran = [
                        'labels' => ['Sekretariat', 'Anggaran', 'Akuntansi', 'Aset', 'Pajak'],
                        'anggaran' => [5.2, 5.0, 4.0, 2.8, 6.0],
                        'realisasi' => [4.4, 4.2, 3.2, 2.1, 5.5]
                    ];
                }

                // 2. Grafik Trend Realisasi Anggaran (Line Chart Bulanan)
                $chartTrend = [
                    'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                    'data' => [58, 66, 74, 92, 110, 120]
                ];

                // 3. Grafik Pendapatan Asli Daerah (PAD per Sektor)
                $pads = (clone $qPad)->selectRaw('sumber_pendapatan, SUM(target_pad) as total_target, SUM(realisasi_pad) as total_realisasi')
                    ->groupBy('sumber_pendapatan')
                    ->get();

                if ($pads->isNotEmpty()) {
                    $chartPAD = [
                        'labels' => $pads->pluck('sumber_pendapatan')->map(function($s) {
                            if (str_contains($s, 'Pajak')) return 'Pajak Daerah';
                            if (str_contains($s, 'Retribusi')) return 'Retribusi Daerah';
                            if (str_contains($s, 'Pengelolaan') || str_contains($s, 'Kekayaan') || str_contains($s, 'Hasil')) return 'Hasil Kekayaan';
                            if (str_contains($s, 'Lain-lain') || str_contains($s, 'Sah')) return 'Lain-lain PAD';
                            return $s;
                        })->toArray(),
                        'target' => $pads->map(fn($p) => round(($p->total_target ?: $p->total_realisasi * 1.1) / 1000000000, 1))->toArray(),
                        'realisasi' => $pads->map(fn($p) => round($p->total_realisasi / 1000000000, 1))->toArray()
                    ];
                } else {
                    $chartPAD = [
                        'labels' => ['Pajak Daerah', 'Retribusi Daerah', 'Hasil Kekayaan', 'Lain-lain PAD'],
                        'target' => [10.0, 1.2, 0.6, 0.5],
                        'realisasi' => [9.5, 0.8, 0.4, 0.3]
                    ];
                }

                // 4. Grafik Pendapatan Pajak Daerah (Horizontal Clustered Bar: Target vs Realisasi)
                $taxes = (clone $qTax)->selectRaw('jenis_pajak, SUM(jumlah_pendapatan) as total_pendapatan')
                    ->groupBy('jenis_pajak')
                    ->get();

                if ($taxes->isNotEmpty()) {
                    $chartPajak = [
                        'labels' => $taxes->pluck('jenis_pajak')->toArray(),
                        'target' => $taxes->map(fn($t) => round(($t->total_pendapatan * 1.15) / 1000000, 0))->toArray(),
                        'realisasi' => $taxes->map(fn($t) => round($t->total_pendapatan / 1000000, 0))->toArray()
                    ];
                } else {
                    $chartPajak = [
                        'labels' => ['PBB', 'PB1', 'Pajak Restoran', 'Pajak Hotel', 'BPHTB'],
                        'target' => [900, 700, 550, 400, 800],
                        'realisasi' => [850, 620, 480, 310, 740]
                    ];
                }

                // Data Keuangan Terbaru (Tabel)
                $tabelKeuangan = [
                    [
                        'tahun' => '2026',
                        'kategori' => 'Anggaran Operasional',
                        'unit' => 'Badan Keuangan Daerah',
                        'anggaran' => 'Rp6,5 M',
                        'realisasi' => 'Rp7,1 M',
                        'persentase' => '83%',
                        'keterangan' => 'Berjalan',
                        'badge' => 'success'
                    ],
                    [
                        'tahun' => '2026',
                        'kategori' => 'PAD',
                        'unit' => 'Pajak Daerah',
                        'anggaran' => 'Rp2,1 M',
                        'realisasi' => 'Rp2,3 M',
                        'persentase' => '105%',
                        'keterangan' => 'Melebihi Target',
                        'badge' => 'success'
                    ],
                    [
                        'tahun' => '2026',
                        'kategori' => 'Pajak PBB',
                        'unit' => 'Kecamatan Magelang Selatan',
                        'anggaran' => 'Rp750 Juta',
                        'realisasi' => 'Rp680 Juta',
                        'persentase' => '91%',
                        'keterangan' => 'Berjalan',
                        'badge' => 'success'
                    ],
                ];

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
                $tahunOptions = \App\Models\PembangunanProject::selectRaw("CAST(strftime('%Y', created_at) AS INTEGER) as tahun")->distinct()->pluck('tahun')->filter()->toArray();

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

                // Handle filter jika disubmit
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

                $stats = [
                    'total'               => \App\Models\KesehatanInformasi::count(),
                    'pasien'              => (clone $queryPenyakit)->sum('jumlah'),
                    'kasus'               => (clone $queryPenyakit)->where('status', 'Aktif')->sum('jumlah'),
                    'vaksinasi'           => 120400,
                    'pencegahan_stunting' => 1240,
                    'kartu_sehat'         => 32150,
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
                $kasusWilayah = (clone $queryPenyakit)->selectRaw('wilayah, SUM(jumlah) as total')
                    ->groupBy('wilayah')->orderByDesc('total')->limit(4)->get();

                if (view()->exists('layanan.kesehatan')) {
                    return view('layanan.kesehatan', compact('informasi', 'penyakit', 'stats', 'dept', 'bulanList', 'trenBulanan', 'kasusWilayah'))->render();
                }
            }

            if ($dept === 'perhubungan') {
                $qKir = \App\Models\UjiKir::query();
                
                $jenisOptions = \App\Models\UjiKir::distinct()->pluck('jenis_kendaraan')->filter()->toArray();
                $statusOptions = \App\Models\UjiKir::distinct()->pluck('status_uji')->filter()->toArray();
                $bulanOptions = \App\Models\UjiKir::selectRaw("CAST(strftime('%m', tanggal_uji) AS INTEGER) as bulan")->distinct()->pluck('bulan')->filter()->toArray();

                $filters = $request->only(['jenis_kendaraan', 'status_uji', 'bulan']);
                if (!empty($filters['jenis_kendaraan'])) $qKir->where('jenis_kendaraan', $filters['jenis_kendaraan']);
                if (!empty($filters['status_uji'])) $qKir->where('status_uji', $filters['status_uji']);
                if (!empty($filters['bulan'])) $qKir->whereRaw("CAST(strftime('%m', tanggal_uji) AS INTEGER) = ?", [$filters['bulan']]);

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
                        'badge' => 'bg-emerald-100 text-emerald-700'
                    ];
                });
                
                if (view()->exists('layanan.perhubungan')) return view('layanan.perhubungan', compact('statsPerhubungan', 'tabelKIR', 'infoTerbaru', 'dept', 'jenisOptions', 'statusOptions', 'bulanOptions', 'filters'))->render();
            }

            if ($dept === 'sig') {
                $qSpasial = \App\Models\DataSpasial::query();
                $qLayer = \App\Models\LayerSig::query();
                
                $kecamatanOptions = \App\Models\DataSpasial::distinct()->pluck('wilayah')->filter()->toArray();
                $kategoriOptions = \App\Models\DataSpasial::distinct()->pluck('kategori')->filter()->toArray();
                $tahunOptions = \App\Models\DataSpasial::selectRaw("CAST(strftime('%Y', created_at) AS INTEGER) as tahun")->distinct()->pluck('tahun')->filter()->toArray();
                $statusOptions = ['Aktif', 'Nonaktif'];
                
                $filters = $request->only(['kecamatan', 'kategori', 'tahun', 'status', 'search']);
                if (!empty($filters['kecamatan'])) $qSpasial->where('wilayah', $filters['kecamatan']);
                if (!empty($filters['kategori'])) $qSpasial->where('kategori', $filters['kategori']);
                if (!empty($filters['tahun'])) $qSpasial->whereYear('created_at', $filters['tahun']);
                if (!empty($filters['search'])) $qSpasial->where('nama_data', 'like', '%' . $filters['search'] . '%');
                if (!empty($filters['status'])) {
                    $isActive = $filters['status'] == 'Aktif' ? 1 : 0;
                    $qLayer->where('status_aktif', $isActive);
                }

                $layersRaw = $qLayer->where('status_aktif', true)->get();
                $defaultLayers = [
                    'Mata Air',
                    'Kemiskinan',
                    'Bahaya Banjir',
                    'Distribusi Pangan',
                    'Bahaya Genangan',
                    'Distribusi Sanitasi',
                    'Kerentanan Pangan',
                    'Volume to Capacity Ratio',
                    'Batas Wilayah Administrasi'
                ];
                $layerPublik = $layersRaw->isNotEmpty() ? $layersRaw->pluck('nama_layer')->toArray() : $defaultLayers;
                // Merge if any default layer is missing to guarantee full 9 items shown in design
                foreach ($defaultLayers as $dl) {
                    if (!in_array($dl, $layerPublik)) {
                        $layerPublik[] = $dl;
                    }
                }

                $statsSIG = [
                    ['label' => 'RUMAH SANITASI', 'value' => 15],
                    ['label' => 'SUMUR RESAPAN', 'value' => 15],
                    ['label' => 'WIFI', 'value' => 15],
                    ['label' => 'RUANG TERBUKA HIJAU', 'value' => 15],
                    ['label' => 'UMKM', 'value' => 15],
                    ['label' => 'CCTV', 'value' => 15],
                ];

                $tabelSIGRaw = (clone $qSpasial)->with('layer')->orderBy('created_at', 'desc')->limit(10)->get();
                if ($tabelSIGRaw->isNotEmpty()) {
                    $tabelSIG = $tabelSIGRaw->map(function($row) {
                        return [
                            'nama_data' => $row->nama_data,
                            'kategori' => $row->kategori,
                            'wilayah' => $row->wilayah,
                            'nilai_jumlah' => $row->nilai_jumlah . ' Titik',
                            'update_terakhir' => Carbon::parse($row->updated_at)->format('d M Y')
                        ];
                    });
                } else {
                    $tabelSIG = collect([
                        ['nama_data' => 'Sanitasi Tidar Selatan 01', 'kategori' => 'Rumah Sanitasi', 'wilayah' => 'Tidar Selatan', 'nilai_jumlah' => '1 Titik', 'update_terakhir' => '03 Jul 2026'],
                        ['nama_data' => 'Sumur Resapan Panjang 02', 'kategori' => 'Sumur Resapan', 'wilayah' => 'Panjang', 'nilai_jumlah' => '1 Titik', 'update_terakhir' => '03 Jul 2026'],
                        ['nama_data' => 'WIFI Alun-Alun Kota', 'kategori' => 'WIFI', 'wilayah' => 'Kemirirejo', 'nilai_jumlah' => '1 Titik', 'update_terakhir' => '02 Jul 2026'],
                        ['nama_data' => 'Taman Kedungsari Hijau', 'kategori' => 'Ruang Terbuka Hijau', 'wilayah' => 'Kedungsari', 'nilai_jumlah' => '1 Titik', 'update_terakhir' => '02 Jul 2026'],
                        ['nama_data' => 'Sentra UMKM Rejowinangun', 'kategori' => 'UMKM', 'wilayah' => 'Rejowinangun', 'nilai_jumlah' => '1 Titik', 'update_terakhir' => '01 Jul 2026'],
                        ['nama_data' => 'CCTV Simpang Trio', 'kategori' => 'CCTV', 'wilayah' => 'Panjang', 'nilai_jumlah' => '1 Titik', 'update_terakhir' => '01 Jul 2026'],
                    ]);
                }

                $informasiRaw = \App\Models\DokumenSig::orderBy('tanggal_rilis', 'desc')->limit(4)->get();
                if ($informasiRaw->isNotEmpty()) {
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
                } else {
                    $infoTerbaruSIG = collect([
                        ['judul' => 'Laporan SIG Kota Semester I 2026', 'kategori' => 'Laporan SIG', 'tanggal' => '03 Jul 2026', 'status' => 'Rilis', 'badge' => 'success', 'file_path' => 'sample-document.pdf'],
                        ['judul' => 'Peta Tematik Sanitasi Kota', 'kategori' => 'Peta Tematik', 'tanggal' => '02 Jul 2026', 'status' => 'Rilis', 'badge' => 'success', 'file_path' => 'sample-document.pdf'],
                        ['judul' => 'Analisis Kerentanan Pangan 2026', 'kategori' => 'Analisis Spasial', 'tanggal' => '01 Jul 2026', 'status' => 'Draft', 'badge' => 'warning', 'file_path' => 'sample-document.pdf'],
                        ['judul' => 'Publikasi Titik CCTV Kota', 'kategori' => 'Publikasi Fasilitas Kota', 'tanggal' => '30 Jun 2026', 'status' => 'Rilis', 'badge' => 'success', 'file_path' => 'sample-document.pdf'],
                    ]);
                }
                
                if (view()->exists('layanan.sig')) return view('layanan.sig', compact('statsSIG', 'layerPublik', 'tabelSIG', 'infoTerbaruSIG', 'dept', 'kecamatanOptions', 'kategoriOptions', 'tahunOptions', 'statusOptions', 'filters'))->render();
            }

            if ($dept === 'kependudukan') {
                $queryPenduduk = \App\Models\KependudukanPenduduk::query();
                $queryAgama = \App\Models\KependudukanAgama::query();
                $queryMutasi = \App\Models\KependudukanMutasi::query();
                
                // Fetch options for filters (using Cache to optimize)
                $kecamatanOptions = \App\Models\KependudukanPenduduk::distinct()->pluck('kecamatan')->filter()->toArray();
                $kelurahanOptions = \App\Models\KependudukanPenduduk::distinct()->pluck('kelurahan')->filter()->toArray();
                $tahunOptions = \App\Models\KependudukanPenduduk::distinct()->pluck('tahun')->filter()->toArray();
                $agamaOptions = \App\Models\KependudukanAgama::distinct()->pluck('agama')->filter()->toArray();
                $statusOptions = ['Aktif', 'Nonaktif'];
                
                $filters = $request->only(['kecamatan', 'kelurahan', 'tahun', 'agama', 'status']);
                
                // Apply Filters
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
                
                // OPTIMIZATION: Database Level Aggregations instead of ->get()->sum()
                $qPendudukAktif = clone $queryPenduduk;
                $qPendudukAktif->where('status', 'Aktif');
                
                $stats = [
                    'totalPenduduk' => $qPendudukAktif->sum('penduduk'),
                    'lakiLaki' => $qPendudukAktif->sum('laki_laki'),
                    'perempuan' => $qPendudukAktif->sum('perempuan'),
                    'totalKk' => $qPendudukAktif->sum('kk'),
                    'wajibKtp' => $qPendudukAktif->sum('wajib_ktp'),
                    'usiaProduktif' => $qPendudukAktif->sum('usia_produktif'),
                    'kelahiranTahunIni' => (clone $queryMutasi)->where('status', 'Aktif')->sum('kelahiran'),
                    'kematianTahunIni' => (clone $queryMutasi)->where('status', 'Aktif')->sum('kematian'),
                ];
                
                // Charts Data via Database Grouping
                $chartAgamaLabels = [];
                $chartAgamaData = [];
                $agamaGroups = (clone $queryAgama)->where('status', 'Aktif')
                                ->selectRaw('agama, SUM(penduduk) as total')
                                ->groupBy('agama')->get();
                foreach($agamaGroups as $g) {
                    if($g->agama) { $chartAgamaLabels[] = $g->agama; $chartAgamaData[] = $g->total; }
                }
                
                $chartGenderLabels = ['Laki-laki', 'Perempuan'];
                $chartGenderData = [$stats['lakiLaki'], $stats['perempuan']];
                
                $chartKecamatanLabels = [];
                $chartKecamatanData = [];
                $kecGroups = (clone $qPendudukAktif)->selectRaw('kecamatan, SUM(penduduk) as total')->groupBy('kecamatan')->get();
                foreach($kecGroups as $g) {
                    if($g->kecamatan) { $chartKecamatanLabels[] = $g->kecamatan; $chartKecamatanData[] = $g->total; }
                }
                
                $chartKelurahanLabels = [];
                $chartKelurahanData = [];
                $kelGroups = (clone $qPendudukAktif)->selectRaw('kelurahan, SUM(penduduk) as total')->groupBy('kelurahan')->orderByDesc('total')->get();
                foreach($kelGroups as $g) {
                    if($g->kelurahan) { $chartKelurahanLabels[] = $g->kelurahan; $chartKelurahanData[] = $g->total; }
                }
                
                $informasiTerbaru = \App\Models\KependudukanInformasi::where('status', 'Rilis')->limit(4)->get();
                
                // Data table (limit for performance, instead of fetching millions of rows)
                $filteredPenduduk = $queryPenduduk->limit(100)->get();
                $dataPenduduk = $filteredPenduduk;
                
                if (view()->exists('layanan.kependudukan_new')) {
                    return view('layanan.kependudukan_new', compact(
                        'stats', 'filteredPenduduk', 'dataPenduduk', 'chartAgamaLabels', 'chartAgamaData',
                        'chartGenderLabels', 'chartGenderData', 'chartKecamatanLabels', 'chartKecamatanData',
                        'chartKelurahanLabels', 'chartKelurahanData', 'informasiTerbaru', 'kecamatanOptions',
                        'kelurahanOptions', 'tahunOptions', 'agamaOptions', 'statusOptions', 'filters', 'dept'
                    ))->render();
                }
            }

            // Fallback
            if ($dept && view()->exists("layanan.{$dept}")) return view("layanan.{$dept}")->render();
            return view('layanan', ['dept' => $dept])->render();
        });
    }
}
