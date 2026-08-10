<?php

namespace App\Http\Controllers;

use App\Models\PerizinanData;
use App\Models\PerizinanJenis;
use App\Models\PerizinanPublikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PerizinanController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $totalPerizinan = PerizinanData::count();
        $disetujui = PerizinanData::where('status', 'Disetujui')->count();
        $proses = PerizinanData::where('status', 'Proses')->count();
        $ditolak = PerizinanData::where('status', 'Ditolak')->count();
        $hariIni = PerizinanData::whereDate('tanggal', today())->count();

        return view('perizinan.dashboard', compact('totalPerizinan', 'disetujui', 'proses', 'ditolak', 'hariIni'));
    }

    // --- DATA PERIZINAN CRUD ---

    public function dataIndex()
    {
        $data = PerizinanData::with('jenisIzin')->orderBy('id', 'desc')->paginate(10);
        return view('perizinan.data.index', compact('data'));
    }

    public function dataCreate()
    {
        $jenisIzin = PerizinanJenis::where('status', 'Aktif')->get();
        return view('perizinan.data.form', compact('jenisIzin'));
    }

    public function dataStore(Request $request)
    {
        $validated = $request->validate([
            'no_dokumen' => 'required|string|unique:perizinan_data,no_dokumen',
            'nama_pemohon' => 'required|string',
            'perizinan_jenis_id' => 'required|exists:perizinan_jenis,id',
            'jenis_permohonan' => 'required|string',
            'tanggal' => 'required|date',
            'status' => 'required|string',
            'lokasi_kecamatan' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        PerizinanData::create($validated);
        return redirect()->route('perizinan.data.index')->with('success', 'Data perizinan berhasil ditambahkan.');
    }

    public function dataEdit(PerizinanData $data)
    {
        $jenisIzin = PerizinanJenis::where('status', 'Aktif')->get();
        return view('perizinan.data.form', compact('data', 'jenisIzin'));
    }

    public function dataUpdate(Request $request, PerizinanData $data)
    {
        $validated = $request->validate([
            'no_dokumen' => 'required|string|unique:perizinan_data,no_dokumen,' . $data->id,
            'nama_pemohon' => 'required|string',
            'perizinan_jenis_id' => 'required|exists:perizinan_jenis,id',
            'jenis_permohonan' => 'required|string',
            'tanggal' => 'required|date',
            'status' => 'required|string',
            'lokasi_kecamatan' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        $data->update($validated);
        return redirect()->route('perizinan.data.index')->with('success', 'Data perizinan berhasil diperbarui.');
    }

    public function dataDestroy(PerizinanData $data)
    {
        $data->delete();
        return redirect()->route('perizinan.data.index')->with('success', 'Data perizinan berhasil dihapus.');
    }


    // --- JENIS IZIN & SLA CRUD ---

    public function jenisIndex()
    {
        $data = PerizinanJenis::orderBy('id', 'desc')->paginate(10);
        return view('perizinan.jenis.index', compact('data'));
    }

    public function jenisCreate()
    {
        return view('perizinan.jenis.form');
    }

    public function jenisStore(Request $request)
    {
        $validated = $request->validate([
            'jenis_izin' => 'required|string',
            'kategori' => 'required|string',
            'sla' => 'required|string',
            'status' => 'required|string',
            'dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
            'keterangan' => 'nullable|string',
        ]);

        if ($request->hasFile('dokumen')) {
            $path = $request->file('dokumen')->store('perizinan/jenis', 'public');
            $validated['dokumen'] = $path;
        }

        PerizinanJenis::create($validated);
        return redirect()->route('perizinan.jenis.index')->with('success', 'Jenis izin berhasil ditambahkan.');
    }

    public function jenisEdit(PerizinanJenis $jenis)
    {
        return view('perizinan.jenis.form', compact('jenis'));
    }

    public function jenisUpdate(Request $request, PerizinanJenis $jenis)
    {
        $validated = $request->validate([
            'jenis_izin' => 'required|string',
            'kategori' => 'required|string',
            'sla' => 'required|string',
            'status' => 'required|string',
            'dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
            'keterangan' => 'nullable|string',
        ]);

        if ($request->hasFile('dokumen')) {
            if ($jenis->dokumen) {
                Storage::disk('public')->delete($jenis->dokumen);
            }
            $path = $request->file('dokumen')->store('perizinan/jenis', 'public');
            $validated['dokumen'] = $path;
        }

        $jenis->update($validated);
        return redirect()->route('perizinan.jenis.index')->with('success', 'Jenis izin berhasil diperbarui.');
    }

    public function jenisDestroy(PerizinanJenis $jenis)
    {
        try {
            if ($jenis->dokumen) {
                Storage::disk('public')->delete($jenis->dokumen);
            }
            $jenis->delete();
            return redirect()->route('perizinan.jenis.index')->with('success', 'Jenis izin berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('perizinan.jenis.index')->with('error', 'Jenis izin tidak dapat dihapus karena masih digunakan.');
        }
    }


    // --- PUBLIKASI MASYARAKAT CRUD ---

    public function publikasiIndex()
    {
        $data = PerizinanPublikasi::orderBy('id', 'desc')->paginate(10);
        return view('perizinan.publikasi.index', compact('data'));
    }

    public function publikasiCreate()
    {
        return view('perizinan.publikasi.form');
    }

    public function publikasiStore(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string',
            'kategori' => 'required|string',
            'format' => 'required|string',
            'status' => 'required|string',
            'dokumen' => 'nullable|file|max:10240',
            'keterangan' => 'nullable|string',
        ]);

        if ($request->hasFile('dokumen')) {
            $path = $request->file('dokumen')->store('perizinan/publikasi', 'public');
            $validated['dokumen'] = $path;
        }

        PerizinanPublikasi::create($validated);
        return redirect()->route('perizinan.publikasi.index')->with('success', 'Publikasi berhasil ditambahkan.');
    }

    public function publikasiEdit(PerizinanPublikasi $publikasi)
    {
        return view('perizinan.publikasi.form', compact('publikasi'));
    }

    public function publikasiUpdate(Request $request, PerizinanPublikasi $publikasi)
    {
        $validated = $request->validate([
            'judul' => 'required|string',
            'kategori' => 'required|string',
            'format' => 'required|string',
            'status' => 'required|string',
            'dokumen' => 'nullable|file|max:10240',
            'keterangan' => 'nullable|string',
        ]);

        if ($request->hasFile('dokumen')) {
            if ($publikasi->dokumen) {
                Storage::disk('public')->delete($publikasi->dokumen);
            }
            $path = $request->file('dokumen')->store('perizinan/publikasi', 'public');
            $validated['dokumen'] = $path;
        }

        $publikasi->update($validated);
        return redirect()->route('perizinan.publikasi.index')->with('success', 'Publikasi berhasil diperbarui.');
    }

    public function publikasiDestroy(PerizinanPublikasi $publikasi)
    {
        if ($publikasi->dokumen) {
            Storage::disk('public')->delete($publikasi->dokumen);
        }
        $publikasi->delete();
        return redirect()->route('perizinan.publikasi.index')->with('success', 'Publikasi berhasil dihapus.');
    }
}
