<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KesehatanController extends Controller
{
    public function dashboard()
    {
        $totalProgram = 48;
        $pasienTerpantau = 12450;
        $kasusAktif = 324;
        $imunisasi = 85210;
        $vaksinasi = 120400;
        $pencegahanStunting = 1240;
        $kartuSehat = 32150;

        return view('kesehatan.dashboard', compact(
            'totalProgram', 'pasienTerpantau', 'kasusAktif', 'imunisasi', 
            'vaksinasi', 'pencegahanStunting', 'kartuSehat'
        ));
    }

    public function programIndex()
    {
        return view('kesehatan.program.index');
    }

    public function programDetail($id)
    {
        return view('kesehatan.program.detail', compact('id'));
    }

    private function getPenyakitData()
    {
        if (!session()->has('penyakit_data')) {
            session(['penyakit_data' => [
                1 => ['id' => 1, 'nama' => 'ISPA', 'jumlah' => 850, 'tahun' => 2026, 'bulan' => 'Februari', 'wilayah' => 'Semua', 'status' => 'Aktif', 'update' => '02 Feb 2026'],
                2 => ['id' => 2, 'nama' => 'Hipertensi', 'jumlah' => 620, 'tahun' => 2026, 'bulan' => 'Maret', 'wilayah' => 'Semua', 'status' => 'Aktif', 'update' => '02 Mar 2026'],
                3 => ['id' => 3, 'nama' => 'Diabetes', 'jumlah' => 540, 'tahun' => 2026, 'bulan' => 'Maret', 'wilayah' => 'Semua', 'status' => 'Aktif', 'update' => '02 Mar 2026'],
                4 => ['id' => 4, 'nama' => 'Diare', 'jumlah' => 310, 'tahun' => 2026, 'bulan' => 'Maret', 'wilayah' => 'Semua', 'status' => 'Aktif', 'update' => '03 Mar 2026'],
                5 => ['id' => 5, 'nama' => 'Demam', 'jumlah' => 280, 'tahun' => 2026, 'bulan' => 'Maret', 'wilayah' => 'Semua', 'status' => 'Aktif', 'update' => '03 Mar 2026'],
                6 => ['id' => 6, 'nama' => 'Stunting', 'jumlah' => 210, 'tahun' => 2026, 'bulan' => 'Maret', 'wilayah' => 'Semua', 'status' => 'Aktif', 'update' => '03 Mar 2026'],
                7 => ['id' => 7, 'nama' => 'TBC', 'jumlah' => 180, 'tahun' => 2026, 'bulan' => 'Maret', 'wilayah' => 'Semua', 'status' => 'Aktif', 'update' => '03 Mar 2026'],
                8 => ['id' => 8, 'nama' => 'DBD', 'jumlah' => 150, 'tahun' => 2026, 'bulan' => 'Maret', 'wilayah' => 'Semua', 'status' => 'Aktif', 'update' => '03 Mar 2026'],
                9 => ['id' => 9, 'nama' => 'Asma', 'jumlah' => 120, 'tahun' => 2026, 'bulan' => 'Maret', 'wilayah' => 'Semua', 'status' => 'Aktif', 'update' => '03 Mar 2026'],
            ]]);
        }
        return session('penyakit_data');
    }

    public function penyakitIndex()
    {
        $data = collect($this->getPenyakitData())->values();
        return view('kesehatan.penyakit.index', compact('data'));
    }

    public function penyakitStore(Request $request)
    {
        $data = $this->getPenyakitData();
        $newId = count($data) > 0 ? max(array_keys($data)) + 1 : 1;
        $data[$newId] = [
            'id' => $newId,
            'nama' => $request->nama,
            'jumlah' => $request->jumlah,
            'tahun' => $request->tahun,
            'bulan' => $request->bulan,
            'wilayah' => $request->wilayah,
            'status' => $request->status,
            'update' => date('d M Y')
        ];
        session(['penyakit_data' => $data]);
        return back()->with('success', 'Data berhasil ditambahkan');
    }

    public function penyakitUpdate(Request $request, $id)
    {
        $data = $this->getPenyakitData();
        if (isset($data[$id])) {
            $data[$id]['nama'] = $request->nama;
            $data[$id]['jumlah'] = $request->jumlah;
            $data[$id]['tahun'] = $request->tahun;
            $data[$id]['bulan'] = $request->bulan;
            $data[$id]['wilayah'] = $request->wilayah;
            $data[$id]['status'] = $request->status;
            $data[$id]['update'] = date('d M Y');
            session(['penyakit_data' => $data]);
        }
        return back()->with('success', 'Data berhasil diubah');
    }

    public function penyakitDestroy($id)
    {
        $data = $this->getPenyakitData();
        if (isset($data[$id])) {
            unset($data[$id]);
            session(['penyakit_data' => $data]);
        }
        return back()->with('success', 'Data berhasil dihapus');
    }

    public function penyakitDetail($id)
    {
        $data = $this->getPenyakitData();
        $penyakit = $data[$id] ?? null;
        if (!$penyakit) abort(404);
        
        return view('kesehatan.penyakit.detail', compact('penyakit'));
    }
}
