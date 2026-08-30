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
                $dataPerizinan = \App\Models\PerizinanData::with('jenisIzin')->orderBy('created_at', 'desc')->limit(10)->get();
                $publikasi = \App\Models\PerizinanPublikasi::where('status', 'Aktif')->orderBy('created_at', 'desc')->get();
                
                $stats = [
                    'total' => \App\Models\PerizinanData::count(),
                    'disetujui' => \App\Models\PerizinanData::where('status', 'Disetujui')->count(),
                    'proses' => \App\Models\PerizinanData::where('status', 'Proses')->count(),
                    'ditolak' => \App\Models\PerizinanData::where('status', 'Ditolak')->count(),
                    'baru' => \App\Models\PerizinanData::where('jenis_permohonan', 'Baru')->count(),
                    'perpanjangan' => \App\Models\PerizinanData::where('jenis_permohonan', 'Perpanjangan')->count(),
                    'lainnya' => \App\Models\PerizinanData::whereNotIn('jenis_permohonan', ['Baru', 'Perpanjangan'])->count(),
                ];
                
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
                
                if (view()->exists('layanan.perizinan')) return view('layanan.perizinan', compact('dataPerizinan', 'publikasi', 'dept', 'stats', 'chartData'))->render();
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

                if (view()->exists('layanan.kepegawaian')) return view('layanan.kepegawaian', compact('stats', 'chartUnitKerja', 'chartGender', 'chartGolongan', 'chartMutasi', 'informasiTerbaru', 'tabelRingkas', 'dept'))->render();
            }

            if ($dept === 'keuangan') {
                $pajakTotal = \App\Models\FinanceTax::sum('jumlah_pendapatan');
                
                $budgets = \App\Models\FinanceBudget::selectRaw('sub_bidang, SUM(total_anggaran) as total_anggaran, SUM(total_realisasi) as total_realisasi')->groupBy('sub_bidang')->get();
                $chartAnggaran = ['labels' => [], 'anggaran' => [], 'realisasi' => []];
                foreach($budgets as $b) {
                    if ($b->sub_bidang) {
                        $chartAnggaran['labels'][] = $b->sub_bidang;
                        $chartAnggaran['anggaran'][] = $b->total_anggaran / 1000000;
                        $chartAnggaran['realisasi'][] = $b->total_realisasi / 1000000;
                    }
                }

                $informasiTerbaru = \App\Models\FinanceInformation::where('status_publikasi', 'Rilis')->orderBy('created_at', 'desc')->limit(5)->get();
                                    
                if (view()->exists('layanan.keuangan')) return view('layanan.keuangan', compact('pajakTotal', 'chartAnggaran', 'informasiTerbaru', 'dept'))->render();
            }

            if ($dept === 'pembangunan') {
                $stats = [
                    'total' => \App\Models\PembangunanProject::count(),
                    'selesai' => \App\Models\PembangunanProject::where('status', 'Selesai')->count(),
                    'berjalan' => \App\Models\PembangunanProject::where('status', 'Berjalan')->count(),
                    'anggaran' => \App\Models\PembangunanProject::sum('total_budget')
                ];
                
                $projects = \App\Models\PembangunanProject::orderBy('created_at', 'desc')->limit(6)->get();
                
                // Optimized spatial query: only fetch specific columns
                $mapData = \App\Models\PembangunanProject::select('name', 'latitude', 'longitude', 'status', 'progress_percentage')
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

                if (view()->exists('layanan.pembangunan')) return view('layanan.pembangunan', compact('stats', 'projects', 'mapData', 'dokumentasi', 'dept'))->render();
            }

            if ($dept === 'kesehatan') {
                $informasi = \App\Models\KesehatanInformasi::orderBy('created_at', 'desc')->limit(5)->get();
                $penyakit = \App\Models\KesehatanPenyakit::orderBy('jumlah', 'desc')->limit(5)->get();
                
                $stats = [
                    'total' => \App\Models\KesehatanInformasi::count(),
                    'pasien' => \App\Models\KesehatanPenyakit::sum('jumlah'),
                    'kasus' => \App\Models\KesehatanPenyakit::where('status', 'Aktif')->sum('jumlah'),
                ];
                
                if (view()->exists('layanan.kesehatan')) return view('layanan.kesehatan', compact('informasi', 'penyakit', 'stats', 'dept'))->render();
            }

            if ($dept === 'perhubungan') {
                $stats = [
                    'total' => \App\Models\UjiKir::count(),
                    'lulus' => \App\Models\UjiKir::where('status_uji', 'Lulus Uji')->count(),
                    'tidak_lulus' => \App\Models\UjiKir::where('status_uji', 'Tidak Lulus')->count(),
                    'uji_ulang' => \App\Models\UjiKir::where('status_uji', 'Perlu Uji Ulang')->count(),
                ];
                
                $statsPerhubungan = [
                    ['label' => 'Total KIR Kendaraan', 'value' => number_format($stats['total']) . ' Unit'],
                    ['label' => 'Lulus Uji', 'value' => number_format($stats['lulus']) . ' Unit'],
                    ['label' => 'Tidak Lulus', 'value' => number_format($stats['tidak_lulus']) . ' Unit'],
                    ['label' => 'Perlu Uji Ulang', 'value' => number_format($stats['uji_ulang']) . ' Unit'],
                ];

                $tabelKIRRaw = \App\Models\UjiKir::orderBy('tanggal_uji', 'desc')->limit(5)->get();
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
                
                if (view()->exists('layanan.perhubungan')) return view('layanan.perhubungan', compact('statsPerhubungan', 'tabelKIR', 'infoTerbaru', 'dept'))->render();
            }

            if ($dept === 'sig') {
                $stats = [
                    'layer' => \App\Models\LayerSig::count(),
                    'data' => \App\Models\DataSpasial::count(),
                ];
                
                $statsSIG = [
                    ['label' => 'TOTAL DATA SPASIAL', 'value' => $stats['data']],
                    ['label' => 'TOTAL LAYER', 'value' => $stats['layer']],
                ];

                $layersRaw = \App\Models\LayerSig::where('status_aktif', true)->get();
                $layerPublik = $layersRaw->pluck('nama_layer')->toArray();

                $tabelSIGRaw = \App\Models\DataSpasial::with('layer')->orderBy('created_at', 'desc')->limit(6)->get();
                $tabelSIG = $tabelSIGRaw->map(function($row) {
                    return [
                        'nama_data' => $row->nama_data,
                        'kategori' => $row->kategori,
                        'wilayah' => $row->wilayah,
                        'nilai_jumlah' => $row->nilai_jumlah . ' Titik',
                        'update_terakhir' => Carbon::parse($row->updated_at)->format('d M Y')
                    ];
                });

                $informasiRaw = \App\Models\DokumenSig::orderBy('tanggal_rilis', 'desc')->limit(4)->get();
                $infoTerbaruSIG = $informasiRaw->map(function($info) {
                    return [
                        'judul' => $info->judul,
                        'kategori' => 'Laporan SIG',
                        'tanggal' => Carbon::parse($info->tanggal_rilis)->format('d M Y'),
                        'status' => $info->status_tag,
                        'badge' => 'success'
                    ];
                });
                
                if (view()->exists('layanan.sig')) return view('layanan.sig', compact('statsSIG', 'layerPublik', 'tabelSIG', 'infoTerbaruSIG', 'dept'))->render();
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
                $kelGroups = (clone $qPendudukAktif)->selectRaw('kelurahan, SUM(penduduk) as total')->groupBy('kelurahan')->get();
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
