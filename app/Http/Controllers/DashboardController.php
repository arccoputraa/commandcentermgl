<?php

namespace App\Http\Controllers;

use App\Models\DataSpasial;
use App\Models\DokumenPerhubungan;
use App\Models\DokumenSig;
use App\Models\Division;
use App\Models\FinanceBudget;
use App\Models\FinancePad;
use App\Models\FinanceTax;
use App\Models\KependudukanAgama;
use App\Models\KependudukanMutasi;
use App\Models\KependudukanPenduduk;
use App\Models\KesehatanPenyakit;
use App\Models\LayerSig;
use App\Models\PegawaiData;
use App\Models\PegawaiMutasi;
use App\Models\PembangunanProject;
use App\Models\PerizinanData;
use App\Models\UjiKir;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function eksekutif(Request $request)
    {
        $currentYear = now()->year;
        $validated = $request->validate([
            'year' => ['sometimes', 'integer', 'between:' . ($currentYear - 10) . ',' . $currentYear],
        ]);
        $year = (int) ($validated['year'] ?? $currentYear);
        $citySummary = $this->generateCitySummary($year);

        $opds = Division::query()
            ->orderBy('name')
            ->get()
            ->map(function (Division $opd) use ($year) {
                $dashboard = $this->resolveOpdDashboard($opd, $year);
                $opd->setAttribute('dashboard_data', $dashboard);
                return $opd;
            });

        $lastDataUpdate = collect([
            FinanceBudget::max('updated_at'),
            FinancePad::max('updated_at'),
            FinanceTax::max('updated_at'),
            PembangunanProject::max('updated_at'),
            KependudukanPenduduk::max('updated_at'),
            PerizinanData::max('updated_at'),
            KesehatanPenyakit::max('updated_at'),
            PegawaiData::max('updated_at'),
            UjiKir::max('updated_at'),
            DataSpasial::max('updated_at'),
            LayerSig::max('updated_at'),
            DokumenSig::max('updated_at'),
            DokumenPerhubungan::max('updated_at'),
        ])->filter()->max();
        $lastDataUpdate = $lastDataUpdate
            ? Carbon::parse($lastDataUpdate)->timezone('Asia/Jakarta')->format('d M Y, H:i') . ' WIB'
            : null;
        $years = range($currentYear, $currentYear - 10);

        return view('dashboard.eksekutif', compact('opds', 'citySummary', 'year', 'years', 'lastDataUpdate'));
    }

    private function resolveOpdDashboard(Division $opd, int $year): array
    {
        $name = Str::lower(trim($opd->name));

        if (Str::contains($name, ['izin', 'perizinan', 'dpmptsp', 'ptsp', 'pelayanan modal'])) {
            return $this->perizinanDashboard($year);
        }
        if (Str::contains($name, ['infrastruktur', 'dpu', 'pupr', 'pekerjaan umum', 'drainase', 'jalan'])) {
            return $this->projectDashboard(true);
        }
        if (Str::contains($name, ['pembangunan', 'bappeda', 'proyek', 'bangun'])) {
            return $this->projectDashboard(false);
        }
        if (Str::contains($name, ['keuangan', 'bppkad', 'bpkad', 'anggaran', 'kas', 'pendapatan', 'pajak'])) {
            return $this->keuanganDashboard($year);
        }
        if (Str::contains($name, ['kependudukan', 'dukcapil', 'capil', 'penduduk', 'demografi'])) {
            return $this->kependudukanDashboard($year);
        }
        if (Str::contains($name, ['kesehatan', 'dinkes', 'rsud', 'puskesmas', 'medis'])) {
            return $this->kesehatanDashboard($year);
        }
        if (Str::contains($name, ['kepegawaian', 'bkpsdm', 'bkd', 'pegawai', 'asn', 'sdm'])) {
            return $this->kepegawaianDashboard($year);
        }
        if (Str::contains($name, ['perhubungan', 'dishub', 'lalulintas', 'kir', 'transportasi'])) {
            return $this->perhubunganDashboard($year);
        }
        if (Str::contains($name, ['sig', 'gis', 'spasial', 'geospasial', 'peta', 'tataruang'])) {
            return $this->sigDashboard();
        }
        if (Str::contains($name, ['pendidikan', 'disdik', 'dikbud', 'sekolah'])) {
            return [
                'available' => false,
                'category' => 'Pendidikan',
                'message' => 'Integrasi data Disdikbud Kota Magelang sedang dalam proses sinkronisasi DAPODIK.',
                'metrics' => [],
                'charts' => [],
            ];
        }
        if (Str::contains($name, ['pariwisata', 'disporapar', 'wisata', 'budaya'])) {
            return [
                'available' => false,
                'category' => 'Pariwisata & Olahraga',
                'message' => 'Integrasi data kunjungan wisata & PAD retribusi pariwisata sedang disiapkan.',
                'metrics' => [],
                'charts' => [],
            ];
        }

        return [
            'available' => false,
            'category' => 'Sektoral',
            'message' => 'Data operasional untuk OPD ini belum terhubung ke Command Center.',
            'metrics' => [],
            'charts' => [],
        ];
    }

    private function generateCitySummary(int $year): array
    {
        // 1. Keuangan
        $budgets = FinanceBudget::query()->where('tahun', $year)->get();
        $pads = FinancePad::query()->where('tahun', $year)->get();

        $budgetTotal = (float) $budgets->sum('total_anggaran');
        $realizedTotal = (float) $budgets->sum('total_realisasi');
        $budgetPercent = $budgetTotal > 0 ? round(($realizedTotal / $budgetTotal) * 100, 1) : 0;

        $padTarget = (float) $pads->sum('target_pad');
        $padRealized = (float) $pads->sum('realisasi_pad');
        $padPercent = $padTarget > 0 ? round(($padRealized / $padTarget) * 100, 1) : 0;
        // 2. Pembangunan
        $projects = PembangunanProject::query()->get();
        $totalProjects = $projects->count();
        $runningProjects = $projects->where('status', 'Berjalan')->count();
        $completedProjects = $projects->where('status', 'Selesai')->count();
        $delayedProjects = $projects->where('status', 'Tertunda')->count();
        $avgProgress = round($projects->avg('progress_percentage') ?? 0, 1);

        // 3. Kependudukan
        $popRecords = KependudukanPenduduk::query()
            ->where('status', 'Aktif')
            ->where('tahun', $year)
            ->get();
        $totalPop = $popRecords->sum('penduduk');
        $totalKk = $popRecords->sum('kk');
        $totalProductive = $popRecords->sum('usia_produktif');

        // 4. Perizinan
        $permits = PerizinanData::query()->whereYear('tanggal', $year)->get();
        $totalPermits = $permits->count();
        $approvedPermits = $permits->where('status', 'Disetujui')->count();
        $processPermits = $permits->where('status', 'Proses')->count();
        $approvalRate = $totalPermits > 0 ? round(($approvedPermits / $totalPermits) * 100, 1) : 0;
        $todayPermits = $permits->filter(fn ($p) => Carbon::parse($p->tanggal)->isToday())->count();

        // 5. Kesehatan & Kepegawaian & Perhubungan
        $healthCases = KesehatanPenyakit::query()->where('tahun', $year)->get();
        $activeHealthCases = $healthCases->where('status', 'Aktif')->sum('jumlah');
        $employees = PegawaiData::query()->where('status_pegawai', 'Aktif')->count();
        $kirTests = UjiKir::query()->whereYear('tanggal_uji', $year)->get();
        $kirPassed = $kirTests->where('status_uji', 'Lulus Uji')->count();
        $kirPassRate = $kirTests->count() > 0 ? round(($kirPassed / $kirTests->count()) * 100, 1) : 0;

        // Visual alerts
        $alerts = [];
        if ($delayedProjects > 0) {
            $alerts[] = [
                'type' => 'danger',
                'title' => 'Proyek Tertunda',
                'desc' => "Terdapat {$delayedProjects} proyek pembangunan dengan status tertunda yang memerlukan percepatan.",
            ];
        }
        if ($year === now()->year && $budgetPercent < 50 && now()->month >= 7) {
            $alerts[] = [
                'type' => 'warning',
                'title' => 'Serapan Anggaran',
                'desc' => "Realisasi APBD masih berada di angka {$budgetPercent}%, perlu evaluasi serapan anggaran semester II.",
            ];
        }
        if ($year === now()->year && $processPermits > 0) {
            $alerts[] = [
                'type' => 'info',
                'title' => 'Pelayanan Perizinan',
                'desc' => "Ada {$processPermits} berkas perizinan sedang diproses aktif oleh DPMPTSP.",
            ];
        }
        $permitSub = 'Disetujui: ' . number_format($approvedPermits, 0, ',', '.');
        if ($year === now()->year) {
            $permitSub .= ' · Hari ini: ' . number_format($todayPermits, 0, ',', '.');
        }

        return [
            'period' => "Tahun {$year} · Proyek kumulatif, ASN kondisi terkini",
            'metrics' => [
                [
                    'label' => 'Realisasi APBD Kota',
                    'value' => $this->formatRupiah($realizedTotal),
                    'sub' => "Dari pagu {$this->formatRupiah($budgetTotal)}",
                    'badge' => "{$budgetPercent}% Capaian",
                    'badge_type' => $budgetPercent >= 75 ? 'success' : ($budgetPercent >= 50 ? 'warning' : 'danger'),
                ],
                [
                    'label' => 'Pendapatan Asli Daerah (PAD)',
                    'value' => $this->formatRupiah($padRealized),
                    'sub' => "Target: {$this->formatRupiah($padTarget)}",
                    'badge' => "{$padPercent}% Target",
                    'badge_type' => $padPercent >= 80 ? 'success' : 'info',
                ],
                [
                    'label' => 'Proyek Strategis Kota',
                    'value' => "{$completedProjects}/{$totalProjects}",
                    'sub' => "Kumulatif semua tahun · progres rata-rata {$avgProgress}%",
                    'badge' => $delayedProjects > 0 ? "{$delayedProjects} Tertunda" : 'Semua On Track',
                    'badge_type' => $delayedProjects > 0 ? 'danger' : 'success',
                ],
                [
                    'label' => 'Total Penduduk Terdata',
                    'value' => number_format($totalPop, 0, ',', '.'),
                    'sub' => number_format($totalKk, 0, ',', '.') . " Kepala Keluarga · data {$year}",
                    'badge' => number_format($totalProductive, 0, ',', '.') . ' Usia Produktif',
                    'badge_type' => 'info',
                ],
                [
                    'label' => 'Pelayanan Perizinan (SLA)',
                    'value' => number_format($totalPermits, 0, ',', '.'),
                    'sub' => $permitSub,
                    'badge' => "{$approvalRate}% Disetujui",
                    'badge_type' => $approvalRate >= 80 ? 'success' : 'warning',
                ],
                [
                    'label' => 'Aparatur Sipil Negara (ASN)',
                    'value' => number_format($employees, 0, ',', '.'),
                    'sub' => 'Snapshot pegawai aktif saat ini',
                    'badge' => 'Pelayanan Publik Siap',
                    'badge_type' => 'neutral',
                ],
                [
                    'label' => 'Kasus Kesehatan Terpantau',
                    'value' => number_format($activeHealthCases, 0, ',', '.'),
                    'sub' => 'Kasus aktif tahun ' . $year,
                    'badge' => $activeHealthCases > 100 ? 'Perlu Pengawasan' : 'Terkendali',
                    'badge_type' => $activeHealthCases > 100 ? 'warning' : 'success',
                ],
                [
                    'label' => 'Kelaikan Kendaraan (Uji KIR)',
                    'value' => "{$kirPassRate}%",
                    'sub' => number_format($kirPassed, 0, ',', '.') . ' kendaraan lolos uji',
                    'badge' => number_format($kirTests->count(), 0, ',', '.') . ' Total Uji',
                    'badge_type' => 'info',
                ],
            ],
            'alerts' => $alerts,
            'charts' => [
                $this->chart('Capaian APBD vs PAD (' . $year . ')', 'bar', ['Pagu APBD', 'Realisasi APBD', 'Target PAD', 'Realisasi PAD'], [[
                    'label' => 'Nilai (Miliar Rp)',
                    'data' => [
                        round($budgetTotal / 1_000_000_000, 2),
                        round($realizedTotal / 1_000_000_000, 2),
                        round($padTarget / 1_000_000_000, 2),
                        round($padRealized / 1_000_000_000, 2),
                    ],
                    'color' => ['#3b82f6', '#10b981', '#6366f1', '#06b6d4'],
                ]], 'miliar'),
                $this->chart('Status Proyek Pembangunan', 'doughnut', ['Selesai', 'Berjalan', 'Tertunda'], [[
                    'label' => 'Jumlah Proyek',
                    'data' => [$completedProjects, $runningProjects, $delayedProjects],
                    'color' => ['#10b981', '#3b82f6', '#ef4444'],
                ]]),
            ],
        ];
    }

    private function perizinanDashboard(int $year): array
    {
        $records = PerizinanData::query()
            ->whereYear('tanggal', $year)
            ->get(['tanggal', 'status']);
        $monthly = array_fill(0, 12, 0);

        foreach ($records as $record) {
            $month = Carbon::parse($record->tanggal)->month;
            if ($month >= 1 && $month <= 12) {
                $monthly[$month - 1]++;
            }
        }
        $statuses = $records->groupBy('status');
        $approved = $records->where('status', 'Disetujui')->count();
        $inProcess = $records->where('status', 'Proses')->count();
        $rejected = $records->where('status', 'Ditolak')->count();
        $total = $records->count();
        $rate = $total > 0 ? round(($approved / $total) * 100, 1) : 0;

        return [
            'available' => true,
            'category' => 'Pelayanan & Penanaman Modal',
            'period' => "Seluruh data izin · Tahun {$year}",
            'metrics' => [
                [
                    'label' => 'Total Permohonan',
                    'value' => number_format($total, 0, ',', '.'),
                    'badge' => 'Akumulatif',
                    'badge_type' => 'neutral',
                ],
                [
                    'label' => 'Izin Disetujui',
                    'value' => number_format($approved, 0, ',', '.'),
                    'badge' => "{$rate}% Tingkat Setuju",
                    'badge_type' => 'success',
                ],
                [
                    'label' => 'Sedang Diproses',
                    'value' => number_format($inProcess, 0, ',', '.'),
                    'badge' => 'SLA Berjalan',
                    'badge_type' => $inProcess > 0 ? 'warning' : 'info',
                ],
                [
                    'label' => 'Permohonan Ditolak',
                    'value' => number_format($rejected, 0, ',', '.'),
                    'badge' => 'Syarat Belum Lengkap',
                    'badge_type' => 'danger',
                ],
                [
                    'label' => 'Permohonan Dicabut',
                    'value' => number_format($records->where('status', 'Dicabut')->count(), 0, ',', '.'),
                    'badge' => 'Oleh Pemohon',
                    'badge_type' => 'neutral',
                ],
                [
                    'label' => $year === now()->year ? 'Permohonan Hari Ini' : "Permohonan Tahun {$year}",
                    'value' => number_format($records->filter(fn ($record) => Carbon::parse($record->tanggal)->isToday())->count(), 0, ',', '.'),
                    'badge' => $year === now()->year ? 'Real-Time Hari Ini' : 'Periode Terpilih',
                    'badge_type' => 'info',
                ],
            ],
            'charts' => [
                $this->chart('Tren Permohonan Izin Bulanan (' . $year . ')', 'line', $this->monthLabels(), [
                    ['label' => 'Jumlah Permohonan', 'data' => $monthly, 'color' => '#06b6d4'],
                ]),
                $this->chart('Distribusi Status Permohonan', 'doughnut', $statuses->keys()->values(), [[
                    'label' => 'Permohonan',
                    'data' => $statuses->map(fn ($items) => $items->count())->values(),
                    'color' => ['#10b981', '#3b82f6', '#f59e0b', '#ef4444', '#8b5cf6'],
                ]]),
            ],
        ];
    }

    private function projectDashboard(bool $infrastructure): array
    {
        $projectQuery = PembangunanProject::query();
        if ($infrastructure) {
            $projectQuery->whereIn('category', ['Jalan', 'Drainase']);
        }

        $projects = $projectQuery->get([
            'category', 'status', 'progress_percentage', 'total_budget', 'realized_budget', 'created_at', 'updated_at',
        ]);
        $statuses = ['Selesai', 'Berjalan', 'Tertunda'];
        $byCategory = $projects->groupBy('category');

        $totalCount = $projects->count();
        $runningCount = $projects->where('status', 'Berjalan')->count();
        $finishedCount = $projects->where('status', 'Selesai')->count();
        $delayedCount = $projects->where('status', 'Tertunda')->count();
        $avgProgress = round($projects->avg('progress_percentage') ?? 0, 1);
        $totalBudget = (float) $projects->sum('total_budget');
        $realizedBudget = (float) $projects->sum('realized_budget');
        $budgetRate = $totalBudget > 0 ? round(($realizedBudget / $totalBudget) * 100, 1) : 0;

        return [
            'available' => true,
            'category' => $infrastructure ? 'Infrastruktur Jalan & Drainase' : 'Pembangunan & Tata Ruang',
            'period' => $infrastructure ? 'Akumulasi proyek sektor infrastruktur' : 'Akumulasi portofolio semua tahun',
            'metrics' => [
                [
                    'label' => 'Total Paket Proyek',
                    'value' => number_format($totalCount, 0, ',', '.'),
                    'badge' => 'Paket Pekerjaan',
                    'badge_type' => 'neutral',
                ],
                [
                    'label' => 'Proyek Selesai',
                    'value' => number_format($finishedCount, 0, ',', '.'),
                    'badge' => $totalCount > 0 ? round(($finishedCount / $totalCount) * 100) . '% Selesai' : '0%',
                    'badge_type' => 'success',
                ],
                [
                    'label' => 'Proyek Berjalan',
                    'value' => number_format($runningCount, 0, ',', '.'),
                    'badge' => "Fisik ~ {$avgProgress}%",
                    'badge_type' => 'info',
                ],
                [
                    'label' => 'Proyek Tertunda',
                    'value' => number_format($delayedCount, 0, ',', '.'),
                    'badge' => $delayedCount > 0 ? 'Perlu Intervensi' : 'Aman',
                    'badge_type' => $delayedCount > 0 ? 'danger' : 'success',
                ],
                [
                    'label' => 'Total Nilai Kontrak',
                    'value' => $this->formatRupiah($totalBudget),
                    'badge' => 'Pagu Anggaran',
                    'badge_type' => 'neutral',
                ],
                [
                    'label' => 'Realisasi Keuangan Fisik',
                    'value' => $this->formatRupiah($realizedBudget),
                    'badge' => "{$budgetRate}% Keuangan",
                    'badge_type' => $budgetRate >= 70 ? 'success' : 'warning',
                ],
            ],
            'charts' => [
                $this->chart($infrastructure ? 'Status Proyek Infrastruktur' : 'Status Proyek Pembangunan', 'bar', $statuses, [[
                    'label' => 'Jumlah Paket',
                    'data' => array_map(fn ($status) => $projects->where('status', $status)->count(), $statuses),
                    'color' => ['#10b981', '#3b82f6', '#ef4444'],
                ]]),
                $this->chart('Distribusi Proyek per Kategori', 'bar', $byCategory->keys()->values(), [[
                    'label' => 'Jumlah Proyek',
                    'data' => $byCategory->map(fn ($items) => $items->count())->values(),
                    'color' => '#06b6d4',
                ]]),
            ],
        ];
    }

    private function keuanganDashboard(int $year): array
    {
        $budgets = FinanceBudget::query()
            ->where('tahun', $year)
            ->get(['sub_bidang', 'total_anggaran', 'total_realisasi']);
        $pads = FinancePad::query()
            ->where('tahun', $year)
            ->get(['sumber_pendapatan', 'target_pad', 'realisasi_pad']);
        $taxes = FinanceTax::query()
            ->where('tahun', $year)
            ->get(['jenis_pajak', 'jumlah_pendapatan']);

        $budgetTotal = (float) $budgets->sum('total_anggaran');
        $realizedTotal = (float) $budgets->sum('total_realisasi');
        $padTarget = (float) $pads->sum('target_pad');
        $padRealized = (float) $pads->sum('realisasi_pad');
        $byDivision = $budgets->groupBy('sub_bidang');
        $bySource = $pads->groupBy('sumber_pendapatan');

        $budgetPercent = $budgetTotal > 0 ? round(($realizedTotal / $budgetTotal) * 100, 1) : 0;
        $padPercent = $padTarget > 0 ? round(($padRealized / $padTarget) * 100, 1) : 0;

        return [
            'available' => true,
            'category' => 'Pengelolaan Keuangan & Aset',
            'period' => "Tahun Anggaran {$year}",
            'metrics' => [
                [
                    'label' => 'Total Belanja APBD',
                    'value' => $this->formatRupiah($budgetTotal),
                    'badge' => 'Pagu APBD',
                    'badge_type' => 'neutral',
                ],
                [
                    'label' => 'Serapan Realisasi Belanja',
                    'value' => $this->formatRupiah($realizedTotal),
                    'badge' => "{$budgetPercent}% Serapan",
                    'badge_type' => $budgetPercent >= 75 ? 'success' : ($budgetPercent >= 50 ? 'warning' : 'danger'),
                ],
                [
                    'label' => 'Target PAD Kota',
                    'value' => $this->formatRupiah($padTarget),
                    'badge' => 'Estimasi PAD',
                    'badge_type' => 'neutral',
                ],
                [
                    'label' => 'Realisasi Penerimaan PAD',
                    'value' => $this->formatRupiah($padRealized),
                    'badge' => "{$padPercent}% Tercapai",
                    'badge_type' => $padPercent >= 80 ? 'success' : 'info',
                ],
                [
                    'label' => 'Pendapatan Pajak Daerah',
                    'value' => $this->formatRupiah((float) $taxes->sum('jumlah_pendapatan')),
                    'badge' => 'Kontribusi Utama',
                    'badge_type' => 'info',
                ],
                [
                    'label' => 'Sisa Belanja Belum Serap',
                    'value' => $this->formatRupiah(max(0, $budgetTotal - $realizedTotal)),
                    'badge' => 'Sisa Pagu',
                    'badge_type' => 'neutral',
                ],
            ],
            'charts' => [
                $this->chart('Belanja vs Realisasi per Bidang (Miliar Rp)', 'bar', $byDivision->keys()->values(), [
                    ['label' => 'Pagu Anggaran', 'data' => $byDivision->map(fn ($items) => round((float) $items->sum('total_anggaran') / 1_000_000_000, 2))->values(), 'color' => '#3b82f6'],
                    ['label' => 'Realisasi Belanja', 'data' => $byDivision->map(fn ($items) => round((float) $items->sum('total_realisasi') / 1_000_000_000, 2))->values(), 'color' => '#10b981'],
                ], 'miliar'),
                $this->chart('Target vs Realisasi PAD (Miliar Rp)', 'bar', $bySource->keys()->values(), [
                    ['label' => 'Target PAD', 'data' => $bySource->map(fn ($items) => round((float) $items->sum('target_pad') / 1_000_000_000, 2))->values(), 'color' => '#6366f1'],
                    ['label' => 'Realisasi PAD', 'data' => $bySource->map(fn ($items) => round((float) $items->sum('realisasi_pad') / 1_000_000_000, 2))->values(), 'color' => '#06b6d4'],
                ], 'miliar'),
            ],
        ];
    }

    private function kependudukanDashboard(int $year): array
    {
        $records = KependudukanPenduduk::query()
            ->where('status', 'Aktif')
            ->where('tahun', $year)
            ->get(['kecamatan', 'penduduk', 'laki_laki', 'perempuan', 'kk', 'wajib_ktp', 'usia_produktif']);
        $byDistrict = $records->groupBy('kecamatan');
        $mutasi = KependudukanMutasi::query()
            ->where('status', 'Aktif')
            ->where('tahun', $year)
            ->get(['kelahiran', 'kematian']);
        $agama = KependudukanAgama::query()
            ->where('status', 'Aktif')
            ->where('tahun', $year)
            ->get(['agama', 'penduduk'])
            ->groupBy('agama');

        $totalPop = $records->sum('penduduk');
        $totalMale = $records->sum('laki_laki');
        $totalFemale = $records->sum('perempuan');
        $totalKk = $records->sum('kk');
        $totalProductive = $records->sum('usia_produktif');
        $prodPercent = $totalPop > 0 ? round(($totalProductive / $totalPop) * 100, 1) : 0;

        return [
            'available' => true,
            'category' => 'Kependudukan & Pencatatan Sipil',
            'period' => "Data Registrasi Penduduk Tahun {$year}",
            'metrics' => [
                [
                    'label' => 'Total Penduduk Kota',
                    'value' => number_format($totalPop, 0, ',', '.'),
                    'badge' => 'Jiwa Terdaftar',
                    'badge_type' => 'neutral',
                ],
                [
                    'label' => 'Kepala Keluarga (KK)',
                    'value' => number_format($totalKk, 0, ',', '.'),
                    'badge' => 'Kartu Keluarga',
                    'badge_type' => 'info',
                ],
                [
                    'label' => 'Usia Produktif (15-64 th)',
                    'value' => number_format($totalProductive, 0, ',', '.'),
                    'badge' => "{$prodPercent}% Bonus Demografi",
                    'badge_type' => 'success',
                ],
                [
                    'label' => 'Wajib Memiliki KTP',
                    'value' => number_format($records->sum('wajib_ktp'), 0, ',', '.'),
                    'badge' => 'Hak Pilih & Identitas',
                    'badge_type' => 'info',
                ],
                [
                    'label' => 'Rasio Gender L/P',
                    'value' => number_format($totalMale, 0, ',', '.') . ' / ' . number_format($totalFemale, 0, ',', '.'),
                    'badge' => 'Laki-laki / Perempuan',
                    'badge_type' => 'neutral',
                ],
                [
                    'label' => 'Mutasi Kelahiran vs Kematian',
                    'value' => '+' . number_format($mutasi->sum('kelahiran'), 0, ',', '.') . ' / -' . number_format($mutasi->sum('kematian'), 0, ',', '.'),
                    'badge' => 'Pertumbuhan Alami',
                    'badge_type' => 'neutral',
                ],
            ],
            'charts' => [
                $this->chart('Penduduk per Wilayah Kecamatan', 'bar', $byDistrict->keys()->values(), [
                    ['label' => 'Laki-laki', 'data' => $byDistrict->map(fn ($items) => $items->sum('laki_laki'))->values(), 'color' => '#3b82f6'],
                    ['label' => 'Perempuan', 'data' => $byDistrict->map(fn ($items) => $items->sum('perempuan'))->values(), 'color' => '#ec4899'],
                ]),
                $this->chart('Komposisi Agama Penduduk', 'doughnut', $agama->keys()->values(), [[
                    'label' => 'Penduduk',
                    'data' => $agama->map(fn ($items) => $items->sum('penduduk'))->values(),
                    'color' => ['#10b981', '#3b82f6', '#f59e0b', '#8b5cf6', '#ef4444', '#06b6d4'],
                ]]),
            ],
        ];
    }

    private function kesehatanDashboard(int $year): array
    {
        $records = KesehatanPenyakit::query()->where('tahun', $year)->get(['nama', 'jumlah', 'wilayah', 'status']);
        $byDisease = $records->groupBy('nama')
            ->map(fn ($items) => $items->sum('jumlah'))
            ->sortDesc()
            ->take(8);
        $byRegion = $records->groupBy('wilayah')
            ->map(fn ($items) => $items->sum('jumlah'))
            ->sortDesc()
            ->take(8);

        $totalCases = $records->sum('jumlah');
        $activeCases = $records->where('status', 'Aktif')->sum('jumlah');
        $activeRate = $totalCases > 0 ? round(($activeCases / $totalCases) * 100, 1) : 0;

        return [
            'available' => true,
            'category' => 'Kesehatan Masyarakat',
            'period' => "Pemantauan Epidemiologi Tahun {$year}",
            'metrics' => [
                [
                    'label' => 'Total Kasus Terdata',
                    'value' => number_format($totalCases, 0, ',', '.'),
                    'badge' => 'Kasus Tercatat',
                    'badge_type' => 'neutral',
                ],
                [
                    'label' => 'Kasus Aktif Terpantau',
                    'value' => number_format($activeCases, 0, ',', '.'),
                    'badge' => $activeCases > 50 ? "{$activeRate}% Perlu Perhatian" : 'Terkendali',
                    'badge_type' => $activeCases > 50 ? 'warning' : 'success',
                ],
                [
                    'label' => 'Varian Penyakit Terpantau',
                    'value' => number_format($records->pluck('nama')->unique()->count(), 0, ',', '.'),
                    'badge' => 'Jenis Terdiagnosa',
                    'badge_type' => 'info',
                ],
                [
                    'label' => 'Wilayah Puskesmas/Kelurahan',
                    'value' => number_format($records->pluck('wilayah')->unique()->count(), 0, ',', '.'),
                    'badge' => 'Cakupan Faskes',
                    'badge_type' => 'neutral',
                ],
                [
                    'label' => 'Laporan Kasus Masuk',
                    'value' => number_format($records->count(), 0, ',', '.'),
                    'badge' => 'Entri Laporan',
                    'badge_type' => 'info',
                ],
                [
                    'label' => 'Status Sanitasi & Faskes',
                    'value' => 'Siaga Aktif',
                    'badge' => 'Sistem Kewaspadaan Dini',
                    'badge_type' => 'success',
                ],
            ],
            'charts' => [
                $this->chart('Top 8 Kasus Penyakit Terbanyak', 'bar', $byDisease->keys()->values(), [[
                    'label' => 'Jumlah Pasien/Kasus', 'data' => $byDisease->values(), 'color' => '#f59e0b',
                ]]),
                $this->chart('Sebaran Kasus Menurut Wilayah', 'bar', $byRegion->keys()->values(), [[
                    'label' => 'Jumlah Kasus', 'data' => $byRegion->values(), 'color' => '#3b82f6',
                ]]),
            ],
        ];
    }

    private function kepegawaianDashboard(int $year): array
    {
        $employees = PegawaiData::query()->get(['jenis_pegawai', 'status_pegawai', 'unit_kerja', 'updated_at']);
        $types = $employees->groupBy('jenis_pegawai');
        $units = $employees->filter(fn ($employee) => filled($employee->unit_kerja))
            ->groupBy('unit_kerja')
            ->map(fn ($items) => $items->count())
            ->sortDesc()
            ->take(8);
        $mutations = PegawaiMutasi::query()
            ->whereYear('tanggal_efektif', $year)
            ->get(['jenis']);

        $totalEmployees = $employees->count();
        $activeEmployees = $employees->where('status_pegawai', 'Aktif')->count();
        $pnsCount = $employees->where('jenis_pegawai', 'PNS')->count();
        $pppkCount = $employees->where('jenis_pegawai', 'PPPK')->count();
        $nonAsnCount = $employees->where('jenis_pegawai', 'Non-ASN')->count();

        return [
            'available' => true,
            'category' => 'Kepegawaian & SDM Aparatur',
            'period' => "Kondisi pegawai saat ini · Mutasi Tahun {$year}",
            'metrics' => [
                [
                    'label' => 'Total Pegawai Pemkot',
                    'value' => number_format($totalEmployees, 0, ',', '.'),
                    'badge' => 'Seluruh ASN & Non-ASN',
                    'badge_type' => 'neutral',
                ],
                [
                    'label' => 'Pegawai Berstatus Aktif',
                    'value' => number_format($activeEmployees, 0, ',', '.'),
                    'badge' => 'Kesiapan Kerja Penuh',
                    'badge_type' => 'success',
                ],
                [
                    'label' => 'Pegawai Negeri Sipil (PNS)',
                    'value' => number_format($pnsCount, 0, ',', '.'),
                    'badge' => $totalEmployees > 0 ? round(($pnsCount / $totalEmployees) * 100) . '% dari Total' : '0%',
                    'badge_type' => 'info',
                ],
                [
                    'label' => 'PPPK / Tenaga Kontrak',
                    'value' => number_format($pppkCount, 0, ',', '.'),
                    'badge' => 'PPPK Terangkat',
                    'badge_type' => 'info',
                ],
                [
                    'label' => 'Pegawai Non-ASN / Honorer',
                    'value' => number_format($nonAsnCount, 0, ',', '.'),
                    'badge' => 'Pendukung Operasional',
                    'badge_type' => 'neutral',
                ],
                [
                    'label' => 'Proyeksi Pensiun / Mutasi',
                    'value' => number_format($mutations->where('jenis', 'Pensiun')->count(), 0, ',', '.') . ' / ' . number_format($mutations->where('jenis', 'Mutasi')->count(), 0, ',', '.'),
                    'badge' => 'Pensiun / Mutasi ' . $year,
                    'badge_type' => 'warning',
                ],
            ],
            'charts' => [
                $this->chart('Distribusi Pegawai per Unit Kerja (Top 8)', 'bar', $units->keys()->values(), [[
                    'label' => 'Jumlah Personel', 'data' => $units->values(), 'color' => '#3b82f6',
                ]]),
                $this->chart('Komposisi Pegawai Menurut Jenis', 'doughnut', $types->keys()->values(), [[
                    'label' => 'Jumlah Personel',
                    'data' => $types->map(fn ($items) => $items->count())->values(),
                    'color' => ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6'],
                ]]),
            ],
        ];
    }

    private function perhubunganDashboard(int $year): array
    {
        $tests = UjiKir::query()
            ->whereYear('tanggal_uji', $year)
            ->get(['status_uji', 'tanggal_uji', 'jenis_kendaraan']);
        $statuses = ['Lulus Uji', 'Tidak Lulus', 'Perlu Uji Ulang'];
        $vehicleTypes = $tests->groupBy('jenis_kendaraan')->map(fn ($items) => $items->count())->sortDesc()->take(8);

        $totalTests = $tests->count();
        $passed = $tests->where('status_uji', 'Lulus Uji')->count();
        $failed = $tests->where('status_uji', 'Tidak Lulus')->count();
        $retest = $tests->where('status_uji', 'Perlu Uji Ulang')->count();
        $passRate = $totalTests > 0 ? round(($passed / $totalTests) * 100, 1) : 0;

        return [
            'available' => true,
            'category' => 'Perhubungan & Kelaikan Jalan',
            'period' => 'Pemeriksaan Kendaraan Bermotor ' . $year,
            'metrics' => [
                [
                    'label' => 'Total Pengujian KIR',
                    'value' => number_format($totalTests, 0, ',', '.'),
                    'badge' => 'Kendaraan Teruji',
                    'badge_type' => 'neutral',
                ],
                [
                    'label' => 'Tingkat Kelulusan Uji',
                    'value' => number_format($passed, 0, ',', '.'),
                    'badge' => "{$passRate}% Laik Jalan",
                    'badge_type' => 'success',
                ],
                [
                    'label' => 'Tidak Lulus Uji',
                    'value' => number_format($failed, 0, ',', '.'),
                    'badge' => $failed > 0 ? 'Potensi Risiko Jalan' : 'Nol Kasus',
                    'badge_type' => $failed > 0 ? 'danger' : 'success',
                ],
                [
                    'label' => 'Perlu Perbaikan / Ulang',
                    'value' => number_format($retest, 0, ',', '.'),
                    'badge' => 'Perbaikan Komponen',
                    'badge_type' => 'warning',
                ],
                [
                    'label' => 'Uji Dilakukan Tahun Ini',
                    'value' => number_format($tests->count(), 0, ',', '.'),
                    'badge' => 'Periode Terpilih',
                    'badge_type' => 'info',
                ],
                [
                    'label' => 'Dokumen & Perizinan Trayek',
                    'value' => number_format(DokumenPerhubungan::count(), 0, ',', '.'),
                    'badge' => 'Arsip Terbit',
                    'badge_type' => 'neutral',
                ],
            ],
            'charts' => [
                $this->chart('Hasil Pengujian Kelaikan Kendaraan', 'doughnut', $statuses, [[
                    'label' => 'Jumlah Unit',
                    'data' => array_map(fn ($status) => $tests->where('status_uji', $status)->count(), $statuses),
                    'color' => ['#10b981', '#ef4444', '#f59e0b'],
                ]]),
                $this->chart('Pengujian Menurut Jenis Kendaraan', 'bar', $vehicleTypes->keys()->values(), [[
                    'label' => 'Jumlah Kendaraan', 'data' => $vehicleTypes->values(), 'color' => '#06b6d4',
                ]]),
            ],
        ];
    }

    private function sigDashboard(): array
    {
        $categories = DataSpasial::query()
            ->selectRaw('kategori, SUM(nilai_jumlah) as total')
            ->groupBy('kategori')
            ->get();
        $byRegion = DataSpasial::query()
            ->selectRaw('wilayah, SUM(nilai_jumlah) as total')
            ->groupBy('wilayah')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        $totalLayers = LayerSig::count();
        $activeLayers = LayerSig::where('status_aktif', true)->count();
        $totalSpasial = DataSpasial::count();
        $geoCount = DataSpasial::whereNotNull('latitude')->whereNotNull('longitude')->count();

        return [
            'available' => true,
            'category' => 'Sistem Informasi Geospasial',
            'period' => 'Peta Tematik & Data Spasial Wilayah',
            'metrics' => [
                [
                    'label' => 'Total Layer Peta',
                    'value' => number_format($totalLayers, 0, ',', '.'),
                    'badge' => 'Layer Tematik',
                    'badge_type' => 'neutral',
                ],
                [
                    'label' => 'Layer Aktif Dipetakan',
                    'value' => number_format($activeLayers, 0, ',', '.'),
                    'badge' => 'Siap Visualisasi',
                    'badge_type' => 'success',
                ],
                [
                    'label' => 'Entri Dataset Spasial',
                    'value' => number_format($totalSpasial, 0, ',', '.'),
                    'badge' => 'Objek Terdata',
                    'badge_type' => 'info',
                ],
                [
                    'label' => 'Dataset Berkoordinat Valid',
                    'value' => number_format($geoCount, 0, ',', '.'),
                    'badge' => $totalSpasial > 0 ? round(($geoCount / $totalSpasial) * 100) . '% Akurat GPS' : '0%',
                    'badge_type' => 'success',
                ],
                [
                    'label' => 'Dokumen Geospasial / RTRW',
                    'value' => number_format(DokumenSig::count(), 0, ',', '.'),
                    'badge' => 'Dokumen Tata Ruang',
                    'badge_type' => 'neutral',
                ],
                [
                    'label' => 'Nilai Agregat Terpetakan',
                    'value' => number_format((float) DataSpasial::sum('nilai_jumlah'), 0, ',', '.'),
                    'badge' => 'Akumulasi Poin',
                    'badge_type' => 'info',
                ],
            ],
            'charts' => [
                $this->chart('Distribusi Nilai per Kategori Peta', 'bar', $categories->pluck('kategori')->values(), [[
                    'label' => 'Total Nilai', 'data' => $categories->pluck('total')->map(fn ($total) => (int) $total)->values(), 'color' => '#3b82f6',
                ]]),
                $this->chart('Sebaran Data Spasial per Wilayah', 'bar', $byRegion->pluck('wilayah')->values(), [[
                    'label' => 'Total Nilai', 'data' => $byRegion->pluck('total')->map(fn ($total) => (int) $total)->values(), 'color' => '#10b981',
                ]]),
            ],
        ];
    }

    private function monthLabels(): array
    {
        return ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    }

    private function chart(string $title, string $type, $labels, array $datasets, ?string $unit = null): array
    {
        return array_filter([
            'title' => $title,
            'type' => $type,
            'labels' => $labels,
            'datasets' => $datasets,
            'unit' => $unit,
        ], fn ($value) => $value !== null);
    }

    private function formatRupiah(float $amount): string
    {
        if ($amount >= 1_000_000_000_000) {
            return 'Rp ' . number_format($amount / 1_000_000_000_000, 2, ',', '.') . ' T';
        }

        if ($amount >= 1_000_000_000) {
            return 'Rp ' . number_format($amount / 1_000_000_000, 2, ',', '.') . ' M';
        }

        if ($amount >= 1_000_000) {
            return 'Rp ' . number_format($amount / 1_000_000, 2, ',', '.') . ' jt';
        }

        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}