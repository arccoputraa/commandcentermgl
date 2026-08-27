<?php

$code = <<<'PHP'
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\KependudukanPenduduk;
use App\Models\KependudukanAgama;
use App\Models\KependudukanWilayah;
use App\Models\KependudukanKartuKeluarga;
use App\Models\KependudukanMutasi;
use App\Models\KependudukanInformasi;

class KependudukanController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'totalPenduduk'    => KependudukanPenduduk::where('status', 'Aktif')->sum('penduduk'),
            'lakiLaki'         => KependudukanPenduduk::where('status', 'Aktif')->sum('laki_laki'),
            'perempuan'        => KependudukanPenduduk::where('status', 'Aktif')->sum('perempuan'),
            'totalKk'          => KependudukanPenduduk::where('status', 'Aktif')->sum('kk'),
            'wajibKtp'         => KependudukanPenduduk::where('status', 'Aktif')->sum('wajib_ktp'),
            'usiaProduktif'    => KependudukanPenduduk::where('status', 'Aktif')->sum('usia_produktif'),
            'kelahiranTahunIni'=> KependudukanMutasi::where('status', 'Aktif')->where('tahun', date('Y'))->sum('kelahiran'),
            'kematianTahunIni' => KependudukanMutasi::where('status', 'Aktif')->where('tahun', date('Y'))->sum('kematian'),
        ];

        // Agama chart
        $agamaRaw = KependudukanAgama::where('status', 'Aktif')->selectRaw('agama, sum(penduduk) as total')->groupBy('agama')->get();
        $agama = $agamaRaw->map(function($i) { return ['label' => $i->agama, 'total' => $i->total]; })->toArray();

        // Kecamatan chart
        $kecRaw = KependudukanPenduduk::where('status', 'Aktif')->selectRaw('kecamatan, sum(penduduk) as total')->groupBy('kecamatan')->get();
        $kecamatan = $kecRaw->map(function($i) { return ['label' => $i->kecamatan, 'total' => $i->total]; })->toArray();

        // Kelurahan table
        $kelurahan = KependudukanPenduduk::orderBy('id', 'desc')->limit(10)->get();

        $publikasi = KependudukanInformasi::where('status', 'Rilis')->orderBy('tanggal', 'desc')->limit(4)->get();

        return view('kependudukan.dashboard', compact('stats', 'agama', 'kecamatan', 'kelurahan', 'publikasi'));
    }

    public function dataPendudukIndex(Request $request)
    {
        $query = KependudukanPenduduk::query();
        if ($request->q) {
            $query->where('kecamatan', 'like', '%'.$request->q.'%')
                  ->orWhere('kelurahan', 'like', '%'.$request->q.'%');
        }
        if ($request->kecamatan) {
            $query->where('kecamatan', $request->kecamatan);
        }
        if ($request->tahun) {
            $query->where('tahun', $request->tahun);
        }
        
        $penduduk = $query->paginate(10);
        $filters = $request->only(['q', 'kecamatan', 'tahun']);
        
        $kecamatanOptions = KependudukanPenduduk::select('kecamatan')->distinct()->pluck('kecamatan')->toArray();
        $tahunOptions = KependudukanPenduduk::select('tahun')->distinct()->pluck('tahun')->toArray();

        return view('kependudukan.data-penduduk.index', compact('penduduk', 'filters', 'kecamatanOptions', 'tahunOptions'));
    }

    public function dataPendudukShow(int $id)
    {
        $item = KependudukanPenduduk::findOrFail($id);
        return view('kependudukan.data-penduduk.show', compact('item', 'id'));
    }

    public function dataPendudukCreate()
    {
        return view('kependudukan.data-penduduk.form');
    }

    public function dataPendudukStore(Request $request)
    {
        KependudukanPenduduk::create($request->all());
        return redirect()->route('kependudukan.data-penduduk.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function dataPendudukEdit(int $id)
    {
        $item = KependudukanPenduduk::findOrFail($id);
        return view('kependudukan.data-penduduk.form', compact('item', 'id'));
    }

    public function dataPendudukUpdate(Request $request, int $id)
    {
        $item = KependudukanPenduduk::findOrFail($id);
        $item->update($request->all());
        return redirect()->route('kependudukan.data-penduduk.index')->with('success', 'Data berhasil diupdate');
    }
    
    public function dataPendudukDestroy(int $id)
    {
        KependudukanPenduduk::findOrFail($id)->delete();
        return redirect()->route('kependudukan.data-penduduk.index')->with('success', 'Data berhasil dihapus');
    }

    // --- AGAMA ---
    public function dataAgamaIndex(Request $request)
    {
        $query = KependudukanAgama::query();
        if ($request->q) $query->where('kecamatan', 'like', '%'.$request->q.'%')->orWhere('agama', 'like', '%'.$request->q.'%');
        if ($request->kecamatan) $query->where('kecamatan', $request->kecamatan);
        if ($request->tahun) $query->where('tahun', $request->tahun);
        
        $agamaList = $query->paginate(10);
        $filters = $request->only(['q', 'kecamatan', 'tahun']);
        
        $kecamatanOptions = KependudukanAgama::select('kecamatan')->distinct()->pluck('kecamatan')->toArray();
        $tahunOptions = KependudukanAgama::select('tahun')->distinct()->pluck('tahun')->toArray();

        return view('kependudukan.data-agama.index', compact('agamaList', 'filters', 'kecamatanOptions', 'tahunOptions'));
    }

    public function dataAgamaShow(int $id)
    {
        $item = KependudukanAgama::findOrFail($id);
        return view('kependudukan.data-agama.show', compact('item', 'id'));
    }

    public function dataAgamaCreate()
    {
        return view('kependudukan.data-agama.form');
    }

    public function dataAgamaStore(Request $request)
    {
        KependudukanAgama::create($request->all());
        return redirect()->route('kependudukan.data-agama.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function dataAgamaEdit(int $id)
    {
        $item = KependudukanAgama::findOrFail($id);
        return view('kependudukan.data-agama.form', compact('item', 'id'));
    }

    public function dataAgamaUpdate(Request $request, int $id)
    {
        $item = KependudukanAgama::findOrFail($id);
        $item->update($request->all());
        return redirect()->route('kependudukan.data-agama.index')->with('success', 'Data berhasil diupdate');
    }

    public function dataAgamaDestroy(int $id)
    {
        KependudukanAgama::findOrFail($id)->delete();
        return redirect()->route('kependudukan.data-agama.index')->with('success', 'Data berhasil dihapus');
    }

    // --- WILAYAH ---
    public function dataWilayahIndex(Request $request)
    {
        $query = KependudukanWilayah::query();
        if ($request->q) $query->where('kecamatan', 'like', '%'.$request->q.'%')->orWhere('kelurahan', 'like', '%'.$request->q.'%');
        if ($request->kecamatan) $query->where('kecamatan', $request->kecamatan);
        
        $wilayah = $query->paginate(10);
        $filters = $request->only(['q', 'kecamatan']);
        
        $kecamatanOptions = KependudukanWilayah::select('kecamatan')->distinct()->pluck('kecamatan')->toArray();

        return view('kependudukan.data-wilayah.index', compact('wilayah', 'filters', 'kecamatanOptions'));
    }

    public function dataWilayahShow(int $id)
    {
        $item = KependudukanWilayah::findOrFail($id);
        return view('kependudukan.data-wilayah.show', compact('item', 'id'));
    }

    public function dataWilayahCreate()
    {
        return view('kependudukan.data-wilayah.form');
    }

    public function dataWilayahStore(Request $request)
    {
        KependudukanWilayah::create($request->all());
        return redirect()->route('kependudukan.data-wilayah.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function dataWilayahEdit(int $id)
    {
        $item = KependudukanWilayah::findOrFail($id);
        return view('kependudukan.data-wilayah.form', compact('item', 'id'));
    }

    public function dataWilayahUpdate(Request $request, int $id)
    {
        $item = KependudukanWilayah::findOrFail($id);
        $item->update($request->all());
        return redirect()->route('kependudukan.data-wilayah.index')->with('success', 'Data berhasil diupdate');
    }

    public function dataWilayahDestroy(int $id)
    {
        KependudukanWilayah::findOrFail($id)->delete();
        return redirect()->route('kependudukan.data-wilayah.index')->with('success', 'Data berhasil dihapus');
    }

    // --- KK ---
    public function dataKartuKeluargaIndex(Request $request)
    {
        $query = KependudukanKartuKeluarga::query();
        if ($request->q) $query->where('kecamatan', 'like', '%'.$request->q.'%')->orWhere('kelurahan', 'like', '%'.$request->q.'%');
        if ($request->kecamatan) $query->where('kecamatan', $request->kecamatan);
        if ($request->tahun) $query->where('tahun', $request->tahun);
        
        $kkList = $query->paginate(10);
        $filters = $request->only(['q', 'kecamatan', 'tahun']);
        
        $kecamatanOptions = KependudukanKartuKeluarga::select('kecamatan')->distinct()->pluck('kecamatan')->toArray();
        $tahunOptions = KependudukanKartuKeluarga::select('tahun')->distinct()->pluck('tahun')->toArray();

        return view('kependudukan.data-kartu-keluarga.index', compact('kkList', 'filters', 'kecamatanOptions', 'tahunOptions'));
    }

    public function dataKartuKeluargaShow(int $id)
    {
        $item = KependudukanKartuKeluarga::findOrFail($id);
        return view('kependudukan.data-kartu-keluarga.show', compact('item', 'id'));
    }

    public function dataKartuKeluargaCreate()
    {
        return view('kependudukan.data-kartu-keluarga.form');
    }

    public function dataKartuKeluargaStore(Request $request)
    {
        KependudukanKartuKeluarga::create($request->all());
        return redirect()->route('kependudukan.data-kartu-keluarga.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function dataKartuKeluargaEdit(int $id)
    {
        $item = KependudukanKartuKeluarga::findOrFail($id);
        return view('kependudukan.data-kartu-keluarga.form', compact('item', 'id'));
    }

    public function dataKartuKeluargaUpdate(Request $request, int $id)
    {
        $item = KependudukanKartuKeluarga::findOrFail($id);
        $item->update($request->all());
        return redirect()->route('kependudukan.data-kartu-keluarga.index')->with('success', 'Data berhasil diupdate');
    }

    public function dataKartuKeluargaDestroy(int $id)
    {
        KependudukanKartuKeluarga::findOrFail($id)->delete();
        return redirect()->route('kependudukan.data-kartu-keluarga.index')->with('success', 'Data berhasil dihapus');
    }

    // --- MUTASI ---
    public function mutasiPendudukIndex(Request $request)
    {
        $query = KependudukanMutasi::query();
        if ($request->q) $query->where('kecamatan', 'like', '%'.$request->q.'%')->orWhere('kelurahan', 'like', '%'.$request->q.'%');
        if ($request->kecamatan) $query->where('kecamatan', $request->kecamatan);
        if ($request->tahun) $query->where('tahun', $request->tahun);
        if ($request->bulan) $query->where('bulan', $request->bulan);
        
        $mutasi = $query->paginate(10);
        $filters = $request->only(['q', 'kecamatan', 'tahun', 'bulan']);
        
        $kecamatanOptions = KependudukanMutasi::select('kecamatan')->distinct()->pluck('kecamatan')->toArray();
        $tahunOptions = KependudukanMutasi::select('tahun')->distinct()->pluck('tahun')->toArray();
        $bulanOptions = KependudukanMutasi::select('bulan')->distinct()->pluck('bulan')->toArray();

        return view('kependudukan.mutasi-penduduk.index', compact('mutasi', 'filters', 'kecamatanOptions', 'tahunOptions', 'bulanOptions'));
    }

    public function mutasiPendudukShow(int $id)
    {
        $item = KependudukanMutasi::findOrFail($id);
        return view('kependudukan.mutasi-penduduk.show', compact('item', 'id'));
    }

    public function mutasiPendudukCreate()
    {
        return view('kependudukan.mutasi-penduduk.form');
    }

    public function mutasiPendudukStore(Request $request)
    {
        KependudukanMutasi::create($request->all());
        return redirect()->route('kependudukan.mutasi-penduduk.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function mutasiPendudukEdit(int $id)
    {
        $item = KependudukanMutasi::findOrFail($id);
        return view('kependudukan.mutasi-penduduk.form', compact('item', 'id'));
    }

    public function mutasiPendudukUpdate(Request $request, int $id)
    {
        $item = KependudukanMutasi::findOrFail($id);
        $item->update($request->all());
        return redirect()->route('kependudukan.mutasi-penduduk.index')->with('success', 'Data berhasil diupdate');
    }

    public function mutasiPendudukDestroy(int $id)
    {
        KependudukanMutasi::findOrFail($id)->delete();
        return redirect()->route('kependudukan.mutasi-penduduk.index')->with('success', 'Data berhasil dihapus');
    }

    // --- INFORMASI ---
    public function informasiTerbaruIndex(Request $request)
    {
        $query = KependudukanInformasi::query();
        if ($request->q) $query->where('judul', 'like', '%'.$request->q.'%')->orWhere('kategori', 'like', '%'.$request->q.'%');
        if ($request->kategori) $query->where('kategori', $request->kategori);
        
        $informasi = $query->paginate(10);
        $filters = $request->only(['q', 'kategori']);
        
        $kategoriOptions = KependudukanInformasi::select('kategori')->distinct()->pluck('kategori')->toArray();

        return view('kependudukan.informasi-terbaru.index', compact('informasi', 'filters', 'kategoriOptions'));
    }

    public function informasiTerbaruCreate()
    {
        return view('kependudukan.informasi-terbaru.form');
    }

    public function informasiTerbaruStore(Request $request)
    {
        $data = $request->all();
        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('kependudukan', 'public');
        }
        KependudukanInformasi::create($data);
        return redirect()->route('kependudukan.informasi-terbaru.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function informasiTerbaruShow(int $id)
    {
        $item = KependudukanInformasi::findOrFail($id);
        return view('kependudukan.informasi-terbaru.show', compact('item', 'id'));
    }

    public function informasiTerbaruPdf(int $id)
    {
        // Mock PDF display
        return redirect()->back();
    }

    public function informasiTerbaruEdit(int $id)
    {
        $item = KependudukanInformasi::findOrFail($id);
        return view('kependudukan.informasi-terbaru.form', compact('item', 'id'));
    }

    public function informasiTerbaruUpdate(Request $request, int $id)
    {
        $item = KependudukanInformasi::findOrFail($id);
        $data = $request->all();
        if ($request->hasFile('file')) {
            if ($item->file) Storage::disk('public')->delete($item->file);
            $data['file'] = $request->file('file')->store('kependudukan', 'public');
        }
        $item->update($data);
        return redirect()->route('kependudukan.informasi-terbaru.index')->with('success', 'Data berhasil diupdate');
    }

    public function informasiTerbaruDestroy(int $id)
    {
        $item = KependudukanInformasi::findOrFail($id);
        if ($item->file) Storage::disk('public')->delete($item->file);
        $item->delete();
        return redirect()->route('kependudukan.informasi-terbaru.index')->with('success', 'Data berhasil dihapus');
    }
}
PHP;

file_put_contents('app/Http/Controllers/KependudukanController.php', $code);
echo "Done replacing KependudukanController.php\n";
