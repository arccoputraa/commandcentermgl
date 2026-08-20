<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KependudukanController extends Controller
{
    private function defaultDataPenduduk(): array
    {
        return [
            ['tahun' => 2026, 'kecamatan' => 'Magelang Tengah', 'kelurahan' => 'Panjang', 'penduduk' => 8240, 'laki_laki' => 4090, 'perempuan' => 4150, 'wajib_ktp' => 6120, 'usia_produktif' => 5430, 'anak' => 1620, 'lansia' => 1190, 'kk' => 2340, 'agama' => 'Islam', 'status' => 'Aktif', 'update' => '03 Jul 2026'],
            ['tahun' => 2026, 'kecamatan' => 'Magelang Selatan', 'kelurahan' => 'Jurangombo Utara', 'penduduk' => 7850, 'laki_laki' => 3920, 'perempuan' => 3930, 'wajib_ktp' => 5870, 'usia_produktif' => 5110, 'anak' => 1510, 'lansia' => 1110, 'kk' => 2180, 'agama' => 'Islam', 'status' => 'Aktif', 'update' => '03 Jul 2026'],
            ['tahun' => 2026, 'kecamatan' => 'Magelang Utara', 'kelurahan' => 'Kedungsari', 'penduduk' => 6730, 'laki_laki' => 3310, 'perempuan' => 3420, 'wajib_ktp' => 5020, 'usia_produktif' => 4480, 'anak' => 1320, 'lansia' => 930, 'kk' => 1920, 'agama' => 'Islam', 'status' => 'Aktif', 'update' => '02 Jul 2026'],
            ['tahun' => 2026, 'kecamatan' => 'Magelang Tengah', 'kelurahan' => 'Kemirirejo', 'penduduk' => 5980, 'laki_laki' => 2930, 'perempuan' => 3050, 'wajib_ktp' => 4460, 'usia_produktif' => 3920, 'anak' => 1190, 'lansia' => 870, 'kk' => 1710, 'agama' => 'Islam', 'status' => 'Aktif', 'update' => '01 Jul 2026'],
            ['tahun' => 2026, 'kecamatan' => 'Magelang Selatan', 'kelurahan' => 'Tidar Selatan', 'penduduk' => 6410, 'laki_laki' => 3180, 'perempuan' => 3230, 'wajib_ktp' => 4800, 'usia_produktif' => 4210, 'anak' => 1250, 'lansia' => 950, 'kk' => 1860, 'agama' => 'Islam', 'status' => 'Aktif', 'update' => '30 Jun 2026'],
        ];
    }

    private function dataPenduduk(): array
    {
        return session('kependudukan_data_penduduk', $this->defaultDataPenduduk());
    }

    private function saveDataPenduduk(array $penduduk): void
    {
        session(['kependudukan_data_penduduk' => array_values($penduduk)]);
    }

    private function defaultDataAgama(): array
    {
        return [
            ['tahun' => 2026, 'kecamatan' => 'Magelang Tengah', 'kelurahan' => 'Panjang', 'agama' => 'Islam', 'penduduk' => 5120, 'persentase' => '62%', 'status' => 'Aktif', 'update' => '03 Jul 2026'],
            ['tahun' => 2026, 'kecamatan' => 'Magelang Tengah', 'kelurahan' => 'Panjang', 'agama' => 'Kristen', 'penduduk' => 1120, 'persentase' => '14%', 'status' => 'Aktif', 'update' => '03 Jul 2026'],
            ['tahun' => 2026, 'kecamatan' => 'Magelang Tengah', 'kelurahan' => 'Panjang', 'agama' => 'Katolik', 'penduduk' => 980, 'persentase' => '12%', 'status' => 'Aktif', 'update' => '03 Jul 2026'],
            ['tahun' => 2026, 'kecamatan' => 'Magelang Selatan', 'kelurahan' => 'Jurangombo Utara', 'agama' => 'Islam', 'penduduk' => 5840, 'persentase' => '74%', 'status' => 'Aktif', 'update' => '02 Jul 2026'],
            ['tahun' => 2026, 'kecamatan' => 'Magelang Utara', 'kelurahan' => 'Kedungsari', 'agama' => 'Islam', 'penduduk' => 4910, 'persentase' => '73%', 'status' => 'Aktif', 'update' => '01 Jul 2026'],
            ['tahun' => 2026, 'kecamatan' => 'Magelang Tengah', 'kelurahan' => 'Panjang', 'agama' => 'Hindu', 'penduduk' => 140, 'persentase' => '2%', 'status' => 'Aktif', 'update' => '03 Jul 2026'],
        ];
    }

    private function dataAgama(): array
    {
        return session('kependudukan_data_agama', $this->defaultDataAgama());
    }

    private function saveDataAgama(array $agama): void
    {
        session(['kependudukan_data_agama' => array_values($agama)]);
    }

    private function defaultDataWilayah(): array
    {
        return [
            ['kecamatan' => 'Magelang Tengah', 'kelurahan' => 'Panjang', 'kode' => '3371011001', 'penduduk' => 8240, 'kk' => 2340, 'laki_laki' => 4090, 'perempuan' => 4150, 'status' => 'Aktif'],
            ['kecamatan' => 'Magelang Selatan', 'kelurahan' => 'Jurangombo Utara', 'kode' => '3371021002', 'penduduk' => 7850, 'kk' => 2180, 'laki_laki' => 3920, 'perempuan' => 3930, 'status' => 'Aktif'],
            ['kecamatan' => 'Magelang Utara', 'kelurahan' => 'Kedungsari', 'kode' => '3371031003', 'penduduk' => 6730, 'kk' => 1920, 'laki_laki' => 3310, 'perempuan' => 3420, 'status' => 'Aktif'],
            ['kecamatan' => 'Magelang Tengah', 'kelurahan' => 'Kemirirejo', 'kode' => '3371011004', 'penduduk' => 5980, 'kk' => 1710, 'laki_laki' => 2930, 'perempuan' => 3050, 'status' => 'Aktif'],
            ['kecamatan' => 'Magelang Selatan', 'kelurahan' => 'Tidar Selatan', 'kode' => '3371021005', 'penduduk' => 6410, 'kk' => 1860, 'laki_laki' => 3180, 'perempuan' => 3230, 'status' => 'Aktif'],
        ];
    }

    private function dataWilayah(): array
    {
        return session('kependudukan_data_wilayah', $this->defaultDataWilayah());
    }

    private function saveDataWilayah(array $wilayah): void
    {
        session(['kependudukan_data_wilayah' => array_values($wilayah)]);
    }

    private function defaultDataKartuKeluarga(): array
    {
        return [
            ['tahun' => 2026, 'kecamatan' => 'Magelang Tengah', 'kelurahan' => 'Panjang', 'kk' => 2340, 'penduduk' => 8240, 'rata_rata' => '3,5 orang', 'status' => 'Aktif', 'update' => '03 Jul 2026'],
            ['tahun' => 2026, 'kecamatan' => 'Magelang Selatan', 'kelurahan' => 'Jurangombo Utara', 'kk' => 2180, 'penduduk' => 7850, 'rata_rata' => '3,6 orang', 'status' => 'Aktif', 'update' => '03 Jul 2026'],
            ['tahun' => 2026, 'kecamatan' => 'Magelang Utara', 'kelurahan' => 'Kedungsari', 'kk' => 1920, 'penduduk' => 6730, 'rata_rata' => '3,5 orang', 'status' => 'Aktif', 'update' => '02 Jul 2026'],
        ];
    }

    private function dataKartuKeluarga(): array
    {
        return session('kependudukan_data_kartu_keluarga', $this->defaultDataKartuKeluarga());
    }

    private function saveDataKartuKeluarga(array $kartuKeluarga): void
    {
        session(['kependudukan_data_kartu_keluarga' => array_values($kartuKeluarga)]);
    }

    private function defaultDataMutasiPenduduk(): array
    {
        return [
            ['tahun' => 2026, 'bulan' => 'Januari', 'kecamatan' => 'Magelang Tengah', 'kelurahan' => 'Panjang', 'kelahiran' => 18, 'kematian' => 7, 'pindah_datang' => 24, 'pindah_keluar' => 15, 'status' => 'Aktif', 'update' => '31 Jan 2026'],
            ['tahun' => 2026, 'bulan' => 'Februari', 'kecamatan' => 'Magelang Selatan', 'kelurahan' => 'Jurangombo Utara', 'kelahiran' => 21, 'kematian' => 9, 'pindah_datang' => 18, 'pindah_keluar' => 12, 'status' => 'Aktif', 'update' => '28 Feb 2026'],
            ['tahun' => 2026, 'bulan' => 'Maret', 'kecamatan' => 'Magelang Utara', 'kelurahan' => 'Kedungsari', 'kelahiran' => 15, 'kematian' => 6, 'pindah_datang' => 20, 'pindah_keluar' => 14, 'status' => 'Aktif', 'update' => '31 Mar 2026'],
            ['tahun' => 2026, 'bulan' => 'April', 'kecamatan' => 'Magelang Tengah', 'kelurahan' => 'Kemirirejo', 'kelahiran' => 12, 'kematian' => 5, 'pindah_datang' => 16, 'pindah_keluar' => 10, 'status' => 'Aktif', 'update' => '30 Apr 2026'],
        ];
    }

    private function dataMutasiPenduduk(): array
    {
        return session('kependudukan_data_mutasi_penduduk', $this->defaultDataMutasiPenduduk());
    }

    private function saveDataMutasiPenduduk(array $mutasi): void
    {
        session(['kependudukan_data_mutasi_penduduk' => array_values($mutasi)]);
    }

    private function defaultDataInformasiTerbaru(): array
    {
        return [
            ['judul' => 'Rekap Data Kependudukan Semester I 2026', 'kategori' => 'Rekap Penduduk', 'file' => 'rekap-penduduk-semester-1.pdf', 'tanggal' => '03 Jul 2026', 'status' => 'Rilis'],
            ['judul' => 'Statistik Pemeluk Agama 2026', 'kategori' => 'Data Agama', 'file' => 'statistik-agama-2026.pdf', 'tanggal' => '02 Jul 2026', 'status' => 'Rilis'],
            ['judul' => 'Laporan Mutasi Penduduk Juni 2026', 'kategori' => 'Mutasi Penduduk', 'file' => 'mutasi-penduduk-juni.pdf', 'tanggal' => '01 Jul 2026', 'status' => 'Rilis'],
            ['judul' => 'Publikasi Penduduk Berdasarkan Wilayah', 'kategori' => 'Statistik Wilayah', 'file' => 'penduduk-wilayah-2026.pdf', 'tanggal' => '30 Jun 2026', 'status' => 'Draft'],
        ];
    }

    private function dataInformasiTerbaru(): array
    {
        return session('kependudukan_data_informasi_terbaru', $this->defaultDataInformasiTerbaru());
    }

    private function saveDataInformasiTerbaru(array $informasi): void
    {
        session(['kependudukan_data_informasi_terbaru' => array_values($informasi)]);
    }

    public function dashboard()
    {
        // Load live session data (falls back to defaults)
        $dataPenduduk  = $this->dataPenduduk();
        $dataAgama     = $this->dataAgama();
        $dataMutasi    = $this->dataMutasiPenduduk();
        $dataInformasi = $this->dataInformasiTerbaru();

        // Compute summary stats from session
        $totalPenduduk  = 0; $lakiLaki = 0; $perempuan = 0;
        $totalKk = 0; $wajibKtp = 0; $usiaProduktif = 0;
        foreach ($dataPenduduk as $item) {
            if ($item['status'] === 'Aktif') {
                $totalPenduduk  += $item['penduduk'];
                $lakiLaki       += $item['laki_laki'];
                $perempuan      += $item['perempuan'];
                $totalKk        += $item['kk'];
                $wajibKtp       += $item['wajib_ktp'];
                $usiaProduktif  += $item['usia_produktif'];
            }
        }
        $kelahiran = 0; $kematian = 0;
        foreach ($dataMutasi as $item) {
            if ($item['status'] === 'Aktif') {
                $kelahiran += $item['kelahiran'];
                $kematian  += $item['kematian'];
            }
        }

        $stats = [
            'totalPenduduk'    => $totalPenduduk,
            'lakiLaki'         => $lakiLaki,
            'perempuan'        => $perempuan,
            'totalKk'          => $totalKk,
            'wajibKtp'         => $wajibKtp,
            'usiaProduktif'    => $usiaProduktif,
            'kelahiranTahunIni'=> $kelahiran,
            'kematianTahunIni' => $kematian,
        ];

        // Agama chart grouped
        $agamaGrouped = [];
        foreach ($dataAgama as $item) {
            if ($item['status'] === 'Aktif') {
                $agamaGrouped[$item['agama']] = ($agamaGrouped[$item['agama']] ?? 0) + $item['penduduk'];
            }
        }
        $agama = array_map(fn($label, $total) => ['label' => $label, 'total' => $total],
            array_keys($agamaGrouped), array_values($agamaGrouped));

        // Kecamatan chart grouped
        $kecamatanGrouped = [];
        foreach ($dataPenduduk as $item) {
            if ($item['status'] === 'Aktif') {
                $kecamatanGrouped[$item['kecamatan']] = ($kecamatanGrouped[$item['kecamatan']] ?? 0) + $item['penduduk'];
            }
        }
        $kecamatan = array_map(fn($label, $total) => ['label' => $label, 'total' => $total],
            array_keys($kecamatanGrouped), array_values($kecamatanGrouped));

        // Kelurahan table
        $kelurahan = array_map(function ($item) {
            return [
                'tahun'     => $item['tahun'],
                'kecamatan' => $item['kecamatan'],
                'kelurahan' => $item['kelurahan'],
                'penduduk'  => $item['penduduk'],
                'kk'        => $item['kk'],
                'agama'     => $item['agama'],
            ];
        }, $dataPenduduk);

        // Publikasi (latest released informasi)
        $publikasi = array_slice(array_filter($dataInformasi, fn($i) => $i['status'] === 'Rilis'), 0, 4);

        return view('kependudukan.dashboard', compact('stats', 'agama', 'kecamatan', 'kelurahan', 'publikasi'));
    }

    public function dataPendudukIndex(Request $request)
    {
        $penduduk = $this->dataPenduduk();
        $filters = $request->only(['q', 'kecamatan', 'tahun']);

        $penduduk = array_map(function ($item, $index) {
            $item['_id'] = $index + 1;
            return $item;
        }, $penduduk, array_keys($penduduk));

        $penduduk = array_values(array_filter($penduduk, function ($item) use ($filters) {
            $keyword = strtolower($filters['q'] ?? '');
            $matchesKeyword = $keyword === ''
                || str_contains(strtolower($item['kecamatan']), $keyword)
                || str_contains(strtolower($item['kelurahan']), $keyword)
                || str_contains((string) $item['tahun'], $keyword);

            $matchesKecamatan = empty($filters['kecamatan']) || $item['kecamatan'] === $filters['kecamatan'];
            $matchesTahun = empty($filters['tahun']) || (string) $item['tahun'] === (string) $filters['tahun'];

            return $matchesKeyword && $matchesKecamatan && $matchesTahun;
        }));

        $allPenduduk = $this->dataPenduduk();
        $kecamatanOptions = array_values(array_unique(array_column($allPenduduk, 'kecamatan')));
        $tahunOptions = array_values(array_unique(array_column($allPenduduk, 'tahun')));

        return view('kependudukan.data-penduduk.index', compact('penduduk', 'filters', 'kecamatanOptions', 'tahunOptions'));
    }

    public function dataPendudukShow(int $id)
    {
        $penduduk = $this->dataPenduduk();
        $item = $penduduk[$id - 1] ?? abort(404);

        return view('kependudukan.data-penduduk.show', compact('item', 'id'));
    }

    public function dataPendudukCreate()
    {
        return view('kependudukan.data-penduduk.form');
    }

    public function dataPendudukStore(Request $request)
    {
        $data = $this->validateDataPenduduk($request);
        $penduduk = $this->dataPenduduk();
        $penduduk[] = $data;
        $this->saveDataPenduduk($penduduk);

        return redirect()->route('kependudukan.data-penduduk.index')->with('success', 'Data penduduk berhasil ditambahkan.');
    }

    public function dataPendudukEdit(int $id)
    {
        $penduduk = $this->dataPenduduk();
        $item = $penduduk[$id - 1] ?? abort(404);

        return view('kependudukan.data-penduduk.form', compact('item', 'id'));
    }

    public function dataPendudukUpdate(Request $request, int $id)
    {
        $penduduk = $this->dataPenduduk();
        abort_unless(isset($penduduk[$id - 1]), 404);

        $penduduk[$id - 1] = $this->validateDataPenduduk($request);
        $this->saveDataPenduduk($penduduk);

        return redirect()->route('kependudukan.data-penduduk.show', $id)->with('success', 'Data penduduk berhasil diperbarui.');
    }

    private function validateDataPenduduk(Request $request): array
    {
        return $request->validate([
            'tahun' => ['required', 'integer', 'min:2000', 'max:2100'],
            'kecamatan' => ['required', 'string', 'max:100'],
            'kelurahan' => ['required', 'string', 'max:100'],
            'penduduk' => ['required', 'integer', 'min:0'],
            'laki_laki' => ['required', 'integer', 'min:0'],
            'perempuan' => ['required', 'integer', 'min:0'],
            'wajib_ktp' => ['required', 'integer', 'min:0'],
            'usia_produktif' => ['required', 'integer', 'min:0'],
            'anak' => ['required', 'integer', 'min:0'],
            'lansia' => ['required', 'integer', 'min:0'],
            'kk' => ['required', 'integer', 'min:0'],
            'agama' => ['required', 'string', 'max:50'],
            'status' => ['required', 'string', 'max:30'],
            'update' => ['required', 'string', 'max:30'],
        ]);
    }

    public function dataAgamaIndex(Request $request)
    {
        $agama = $this->dataAgama();
        $filters = $request->only(['q', 'kecamatan', 'agama']);

        $agama = array_map(function ($item, $index) {
            $item['_id'] = $index + 1;
            return $item;
        }, $agama, array_keys($agama));

        $agama = array_values(array_filter($agama, function ($item) use ($filters) {
            $keyword = strtolower($filters['q'] ?? '');
            $matchesKeyword = $keyword === ''
                || str_contains(strtolower($item['kecamatan']), $keyword)
                || str_contains(strtolower($item['kelurahan']), $keyword)
                || str_contains(strtolower($item['agama']), $keyword)
                || str_contains((string) $item['tahun'], $keyword);

            $matchesKecamatan = empty($filters['kecamatan']) || $item['kecamatan'] === $filters['kecamatan'];
            $matchesAgama = empty($filters['agama']) || $item['agama'] === $filters['agama'];

            return $matchesKeyword && $matchesKecamatan && $matchesAgama;
        }));

        $allAgama = $this->dataAgama();
        $kecamatanOptions = array_values(array_unique(array_column($allAgama, 'kecamatan')));
        $agamaOptions = array_values(array_unique(array_column($allAgama, 'agama')));

        return view('kependudukan.data-agama.index', compact('agama', 'filters', 'kecamatanOptions', 'agamaOptions'));
    }

    public function dataAgamaShow(int $id)
    {
        $agama = $this->dataAgama();
        $item = $agama[$id - 1] ?? abort(404);

        return view('kependudukan.data-agama.show', compact('item', 'id'));
    }

    public function dataAgamaCreate()
    {
        return view('kependudukan.data-agama.form');
    }

    public function dataAgamaStore(Request $request)
    {
        $data = $this->validateDataAgama($request);
        $agama = $this->dataAgama();
        $agama[] = $data;
        $this->saveDataAgama($agama);

        return redirect()->route('kependudukan.data-agama.index')->with('success', 'Data agama berhasil ditambahkan.');
    }

    public function dataAgamaEdit(int $id)
    {
        $agama = $this->dataAgama();
        $item = $agama[$id - 1] ?? abort(404);

        return view('kependudukan.data-agama.form', compact('item', 'id'));
    }

    public function dataAgamaUpdate(Request $request, int $id)
    {
        $agama = $this->dataAgama();
        abort_unless(isset($agama[$id - 1]), 404);

        $agama[$id - 1] = $this->validateDataAgama($request);
        $this->saveDataAgama($agama);

        return redirect()->route('kependudukan.data-agama.show', $id)->with('success', 'Data agama berhasil diperbarui.');
    }

    public function dataAgamaDestroy(int $id)
    {
        $agama = $this->dataAgama();
        abort_unless(isset($agama[$id - 1]), 404);

        unset($agama[$id - 1]);
        $this->saveDataAgama($agama);

        return redirect()->route('kependudukan.data-agama.index')->with('success', 'Data agama berhasil dihapus.');
    }

    private function validateDataAgama(Request $request): array
    {
        return $request->validate([
            'tahun' => ['required', 'integer', 'min:2000', 'max:2100'],
            'kecamatan' => ['required', 'string', 'max:100'],
            'kelurahan' => ['required', 'string', 'max:100'],
            'agama' => ['required', 'string', 'max:50'],
            'penduduk' => ['required', 'integer', 'min:0'],
            'persentase' => ['required', 'string', 'max:20'],
            'status' => ['required', 'string', 'max:30'],
            'update' => ['required', 'string', 'max:30'],
        ]);
    }

    public function dataWilayahIndex(Request $request)
    {
        $wilayah = $this->dataWilayah();
        $filters = $request->only(['q', 'kecamatan', 'status']);

        $wilayah = array_map(function ($item, $index) {
            $item['_id'] = $index + 1;
            return $item;
        }, $wilayah, array_keys($wilayah));

        $wilayah = array_values(array_filter($wilayah, function ($item) use ($filters) {
            $keyword = strtolower($filters['q'] ?? '');
            $matchesKeyword = $keyword === ''
                || str_contains(strtolower($item['kecamatan']), $keyword)
                || str_contains(strtolower($item['kelurahan']), $keyword)
                || str_contains(strtolower($item['kode']), $keyword);

            $matchesKecamatan = empty($filters['kecamatan']) || $item['kecamatan'] === $filters['kecamatan'];
            $matchesStatus = empty($filters['status']) || $item['status'] === $filters['status'];

            return $matchesKeyword && $matchesKecamatan && $matchesStatus;
        }));

        $allWilayah = $this->dataWilayah();
        $kecamatanOptions = array_values(array_unique(array_column($allWilayah, 'kecamatan')));
        $statusOptions = array_values(array_unique(array_column($allWilayah, 'status')));

        return view('kependudukan.data-wilayah.index', compact('wilayah', 'filters', 'kecamatanOptions', 'statusOptions'));
    }

    public function dataWilayahShow(int $id)
    {
        $wilayah = $this->dataWilayah();
        $item = $wilayah[$id - 1] ?? abort(404);

        return view('kependudukan.data-wilayah.show', compact('item', 'id'));
    }

    public function dataWilayahCreate()
    {
        return view('kependudukan.data-wilayah.form');
    }

    public function dataWilayahStore(Request $request)
    {
        $data = $this->validateDataWilayah($request);
        $wilayah = $this->dataWilayah();
        $wilayah[] = $data;
        $this->saveDataWilayah($wilayah);

        return redirect()->route('kependudukan.data-wilayah.index')->with('success', 'Data wilayah berhasil ditambahkan.');
    }

    public function dataWilayahEdit(int $id)
    {
        $wilayah = $this->dataWilayah();
        $item = $wilayah[$id - 1] ?? abort(404);

        return view('kependudukan.data-wilayah.form', compact('item', 'id'));
    }

    public function dataWilayahUpdate(Request $request, int $id)
    {
        $wilayah = $this->dataWilayah();
        abort_unless(isset($wilayah[$id - 1]), 404);

        $wilayah[$id - 1] = $this->validateDataWilayah($request);
        $this->saveDataWilayah($wilayah);

        return redirect()->route('kependudukan.data-wilayah.show', $id)->with('success', 'Data wilayah berhasil diperbarui.');
    }

    public function dataWilayahDestroy(int $id)
    {
        $wilayah = $this->dataWilayah();
        abort_unless(isset($wilayah[$id - 1]), 404);

        unset($wilayah[$id - 1]);
        $this->saveDataWilayah($wilayah);

        return redirect()->route('kependudukan.data-wilayah.index')->with('success', 'Data wilayah berhasil dihapus.');
    }

    private function validateDataWilayah(Request $request): array
    {
        return $request->validate([
            'kecamatan' => ['required', 'string', 'max:100'],
            'kelurahan' => ['required', 'string', 'max:100'],
            'kode' => ['required', 'string', 'max:30'],
            'penduduk' => ['required', 'integer', 'min:0'],
            'kk' => ['required', 'integer', 'min:0'],
            'laki_laki' => ['required', 'integer', 'min:0'],
            'perempuan' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'string', 'max:30'],
        ]);
    }

    public function dataKartuKeluargaIndex(Request $request)
    {
        $kartuKeluarga = $this->dataKartuKeluarga();
        $filters = $request->only(['q', 'kecamatan', 'tahun']);

        $kartuKeluarga = array_map(function ($item, $index) {
            $item['_id'] = $index + 1;
            return $item;
        }, $kartuKeluarga, array_keys($kartuKeluarga));

        $kartuKeluarga = array_values(array_filter($kartuKeluarga, function ($item) use ($filters) {
            $keyword = strtolower($filters['q'] ?? '');
            $matchesKeyword = $keyword === ''
                || str_contains(strtolower($item['kecamatan']), $keyword)
                || str_contains(strtolower($item['kelurahan']), $keyword)
                || str_contains((string) $item['tahun'], $keyword);

            $matchesKecamatan = empty($filters['kecamatan']) || $item['kecamatan'] === $filters['kecamatan'];
            $matchesTahun = empty($filters['tahun']) || (string) $item['tahun'] === (string) $filters['tahun'];

            return $matchesKeyword && $matchesKecamatan && $matchesTahun;
        }));

        $allKartuKeluarga = $this->dataKartuKeluarga();
        $kecamatanOptions = array_values(array_unique(array_column($allKartuKeluarga, 'kecamatan')));
        $tahunOptions = array_values(array_unique(array_column($allKartuKeluarga, 'tahun')));

        return view('kependudukan.data-kartu-keluarga.index', compact('kartuKeluarga', 'filters', 'kecamatanOptions', 'tahunOptions'));
    }

    public function dataKartuKeluargaShow(int $id)
    {
        $kartuKeluarga = $this->dataKartuKeluarga();
        $item = $kartuKeluarga[$id - 1] ?? abort(404);

        return view('kependudukan.data-kartu-keluarga.show', compact('item', 'id'));
    }

    public function dataKartuKeluargaCreate()
    {
        return view('kependudukan.data-kartu-keluarga.form');
    }

    public function dataKartuKeluargaStore(Request $request)
    {
        $data = $this->validateDataKartuKeluarga($request);
        $kartuKeluarga = $this->dataKartuKeluarga();
        $kartuKeluarga[] = $data;
        $this->saveDataKartuKeluarga($kartuKeluarga);

        return redirect()->route('kependudukan.data-kartu-keluarga.index')->with('success', 'Data kartu keluarga berhasil ditambahkan.');
    }

    public function dataKartuKeluargaEdit(int $id)
    {
        $kartuKeluarga = $this->dataKartuKeluarga();
        $item = $kartuKeluarga[$id - 1] ?? abort(404);

        return view('kependudukan.data-kartu-keluarga.form', compact('item', 'id'));
    }

    public function dataKartuKeluargaUpdate(Request $request, int $id)
    {
        $kartuKeluarga = $this->dataKartuKeluarga();
        abort_unless(isset($kartuKeluarga[$id - 1]), 404);

        $kartuKeluarga[$id - 1] = $this->validateDataKartuKeluarga($request);
        $this->saveDataKartuKeluarga($kartuKeluarga);

        return redirect()->route('kependudukan.data-kartu-keluarga.show', $id)->with('success', 'Data kartu keluarga berhasil diperbarui.');
    }

    public function dataKartuKeluargaDestroy(int $id)
    {
        $kartuKeluarga = $this->dataKartuKeluarga();
        abort_unless(isset($kartuKeluarga[$id - 1]), 404);

        unset($kartuKeluarga[$id - 1]);
        $this->saveDataKartuKeluarga($kartuKeluarga);

        return redirect()->route('kependudukan.data-kartu-keluarga.index')->with('success', 'Data kartu keluarga berhasil dihapus.');
    }

    private function validateDataKartuKeluarga(Request $request): array
    {
        return $request->validate([
            'tahun' => ['required', 'integer', 'min:2000', 'max:2100'],
            'kecamatan' => ['required', 'string', 'max:100'],
            'kelurahan' => ['required', 'string', 'max:100'],
            'kk' => ['required', 'integer', 'min:0'],
            'penduduk' => ['required', 'integer', 'min:0'],
            'rata_rata' => ['required', 'string', 'max:30'],
            'status' => ['required', 'string', 'max:30'],
            'update' => ['required', 'string', 'max:30'],
        ]);
    }

    public function mutasiPendudukIndex(Request $request)
    {
        $mutasi = $this->dataMutasiPenduduk();
        $filters = $request->only(['q', 'kecamatan', 'bulan']);

        $mutasi = array_map(function ($item, $index) {
            $item['_id'] = $index + 1;
            return $item;
        }, $mutasi, array_keys($mutasi));

        $mutasi = array_values(array_filter($mutasi, function ($item) use ($filters) {
            $keyword = strtolower($filters['q'] ?? '');
            $matchesKeyword = $keyword === ''
                || str_contains(strtolower($item['bulan']), $keyword)
                || str_contains(strtolower($item['kecamatan']), $keyword)
                || str_contains(strtolower($item['kelurahan']), $keyword)
                || str_contains((string) $item['tahun'], $keyword);

            $matchesKecamatan = empty($filters['kecamatan']) || $item['kecamatan'] === $filters['kecamatan'];
            $matchesBulan = empty($filters['bulan']) || $item['bulan'] === $filters['bulan'];

            return $matchesKeyword && $matchesKecamatan && $matchesBulan;
        }));

        $allMutasi = $this->dataMutasiPenduduk();
        $kecamatanOptions = array_values(array_unique(array_column($allMutasi, 'kecamatan')));
        $bulanOptions = array_values(array_unique(array_column($allMutasi, 'bulan')));

        return view('kependudukan.mutasi-penduduk.index', compact('mutasi', 'filters', 'kecamatanOptions', 'bulanOptions'));
    }

    public function mutasiPendudukShow(int $id)
    {
        $mutasi = $this->dataMutasiPenduduk();
        $item = $mutasi[$id - 1] ?? abort(404);

        return view('kependudukan.mutasi-penduduk.show', compact('item', 'id'));
    }

    public function mutasiPendudukCreate()
    {
        return view('kependudukan.mutasi-penduduk.form');
    }

    public function mutasiPendudukStore(Request $request)
    {
        $data = $this->validateDataMutasiPenduduk($request);
        $mutasi = $this->dataMutasiPenduduk();
        $mutasi[] = $data;
        $this->saveDataMutasiPenduduk($mutasi);

        return redirect()->route('kependudukan.mutasi-penduduk.index')->with('success', 'Data mutasi penduduk berhasil ditambahkan.');
    }

    public function mutasiPendudukEdit(int $id)
    {
        $mutasi = $this->dataMutasiPenduduk();
        $item = $mutasi[$id - 1] ?? abort(404);

        return view('kependudukan.mutasi-penduduk.form', compact('item', 'id'));
    }

    public function mutasiPendudukUpdate(Request $request, int $id)
    {
        $mutasi = $this->dataMutasiPenduduk();
        abort_unless(isset($mutasi[$id - 1]), 404);

        $mutasi[$id - 1] = $this->validateDataMutasiPenduduk($request);
        $this->saveDataMutasiPenduduk($mutasi);

        return redirect()->route('kependudukan.mutasi-penduduk.show', $id)->with('success', 'Data mutasi penduduk berhasil diperbarui.');
    }

    public function mutasiPendudukDestroy(int $id)
    {
        $mutasi = $this->dataMutasiPenduduk();
        abort_unless(isset($mutasi[$id - 1]), 404);

        unset($mutasi[$id - 1]);
        $this->saveDataMutasiPenduduk($mutasi);

        return redirect()->route('kependudukan.mutasi-penduduk.index')->with('success', 'Data mutasi penduduk berhasil dihapus.');
    }

    private function validateDataMutasiPenduduk(Request $request): array
    {
        return $request->validate([
            'tahun' => ['required', 'integer', 'min:2000', 'max:2100'],
            'bulan' => ['required', 'string', 'max:30'],
            'kecamatan' => ['required', 'string', 'max:100'],
            'kelurahan' => ['required', 'string', 'max:100'],
            'kelahiran' => ['required', 'integer', 'min:0'],
            'kematian' => ['required', 'integer', 'min:0'],
            'pindah_datang' => ['required', 'integer', 'min:0'],
            'pindah_keluar' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'string', 'max:30'],
            'update' => ['required', 'string', 'max:30'],
        ]);
    }

    public function informasiTerbaruIndex(Request $request)
    {
        $informasi = $this->dataInformasiTerbaru();
        $filters = $request->only(['q', 'kategori', 'status']);

        $informasi = array_map(function ($item, $index) {
            $item['_id'] = $index + 1;
            return $item;
        }, $informasi, array_keys($informasi));

        $informasi = array_values(array_filter($informasi, function ($item) use ($filters) {
            $keyword = strtolower($filters['q'] ?? '');
            $matchesKeyword = $keyword === ''
                || str_contains(strtolower($item['judul']), $keyword)
                || str_contains(strtolower($item['kategori']), $keyword)
                || str_contains(strtolower($item['file']), $keyword);

            $matchesKategori = empty($filters['kategori']) || $item['kategori'] === $filters['kategori'];
            $matchesStatus = empty($filters['status']) || $item['status'] === $filters['status'];

            return $matchesKeyword && $matchesKategori && $matchesStatus;
        }));

        $allInformasi = $this->dataInformasiTerbaru();
        $kategoriOptions = array_values(array_unique(array_column($allInformasi, 'kategori')));
        $statusOptions = array_values(array_unique(array_column($allInformasi, 'status')));

        return view('kependudukan.informasi-terbaru.index', compact('informasi', 'filters', 'kategoriOptions', 'statusOptions'));
    }

    public function informasiTerbaruCreate()
    {
        return view('kependudukan.informasi-terbaru.form');
    }

    public function informasiTerbaruStore(Request $request)
    {
        $data = $this->validateInformasiTerbaru($request, true);
        $data = $this->storeInformasiTerbaruPdf($request, $data);
        
        $informasi = $this->dataInformasiTerbaru();
        $informasi[] = $data;
        $this->saveDataInformasiTerbaru($informasi);

        return redirect()->route('kependudukan.informasi-terbaru.index')->with('success', 'Informasi terbaru berhasil ditambahkan.');
    }

    public function informasiTerbaruShow(int $id)
    {
        $informasi = $this->dataInformasiTerbaru();
        $item = $informasi[$id - 1] ?? abort(404);

        return view('kependudukan.informasi-terbaru.show', compact('item', 'id'));
    }

    public function informasiTerbaruPdf(int $id)
    {
        $informasi = $this->dataInformasiTerbaru();
        $item = $informasi[$id - 1] ?? abort(404);

        abort_if(empty($item['file_path']) || !Storage::disk('public')->exists($item['file_path']), 404);

        return Storage::disk('public')->response($item['file_path'], $item['file']);
    }

    public function informasiTerbaruEdit(int $id)
    {
        $informasi = $this->dataInformasiTerbaru();
        $item = $informasi[$id - 1] ?? abort(404);

        return view('kependudukan.informasi-terbaru.form', compact('item', 'id'));
    }

    public function informasiTerbaruUpdate(Request $request, int $id)
    {
        $informasi = $this->dataInformasiTerbaru();
        abort_unless(isset($informasi[$id - 1]), 404);

        $data = $this->validateInformasiTerbaru($request, false);
        $informasi[$id - 1] = $this->storeInformasiTerbaruPdf($request, $data, $informasi[$id - 1]);
        $this->saveDataInformasiTerbaru($informasi);

        return redirect()->route('kependudukan.informasi-terbaru.show', $id)->with('success', 'Informasi terbaru berhasil diperbarui.');
    }

    public function informasiTerbaruDestroy(int $id)
    {
        $informasi = $this->dataInformasiTerbaru();
        abort_unless(isset($informasi[$id - 1]), 404);

        if (!empty($informasi[$id - 1]['file_path'])) {
            Storage::disk('public')->delete($informasi[$id - 1]['file_path']);
        }

        unset($informasi[$id - 1]);
        $this->saveDataInformasiTerbaru($informasi);

        return redirect()->route('kependudukan.informasi-terbaru.index')->with('success', 'Informasi terbaru berhasil dihapus.');
    }

    private function validateInformasiTerbaru(Request $request, bool $isCreate): array
    {
        return $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'max:100'],
            'file' => [$isCreate ? 'required' : 'nullable', 'file', 'mimes:pdf', 'max:10240'],
            'tanggal' => ['required', 'string', 'max:30'],
            'status' => ['required', 'string', 'in:Rilis,Draft'],
        ]);
    }

    private function storeInformasiTerbaruPdf(Request $request, array $data, ?array $currentItem = null): array
    {
        unset($data['file']);

        if ($request->hasFile('file')) {
            if (!empty($currentItem['file_path'])) {
                Storage::disk('public')->delete($currentItem['file_path']);
            }

            $uploadedFile = $request->file('file');
            $data['file'] = $uploadedFile->getClientOriginalName();
            $data['file_path'] = $uploadedFile->store('kependudukan/informasi-terbaru', 'public');

            return $data;
        }

        $data['file'] = $currentItem['file'] ?? '';
        $data['file_path'] = $currentItem['file_path'] ?? null;

        return $data;
    }
}
