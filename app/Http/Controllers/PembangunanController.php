<?php

namespace App\Http\Controllers;

use App\Models\PembangunanProject;
use App\Models\PembangunanDocument;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PembangunanController extends Controller
{
    public function dashboard(Request $request)
    {
        // 1. Filter Query
        $query = PembangunanProject::query();
        
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('project_code', 'like', '%' . $request->search . '%');
        }
        
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('category', $request->kategori);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $projects = $query->get();

        // 2. KPI Summary
        $kpi = [
            'total_proyek' => $projects->count(),
            'proyek_berjalan' => $projects->where('status', 'Berjalan')->count(),
            'proyek_selesai' => $projects->where('status', 'Selesai')->count(),
            'proyek_tertunda' => $projects->where('status', 'Tertunda')->count(),
            'total_anggaran' => $projects->sum('total_budget'),
            'total_realisasi' => $projects->sum('realized_budget'),
            'rata_progres' => $projects->count() > 0 ? $projects->avg('progress_percentage') : 0,
            'update_terakhir' => $projects->max('updated_at') ? Carbon::parse($projects->max('updated_at'))->format('d M Y') : '-',
        ];

        // 3. Chart Data
        // a. Progres Proyek per Bulan (Count by created_at month for this year)
        $currentYear = date('Y');
        $monthlyProjectsRaw = PembangunanProject::selectRaw("CAST(strftime('%m', created_at) AS INTEGER) as month, count(*) as total")
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->get();
        $chartBulan = array_fill(1, 12, 0);
        foreach($monthlyProjectsRaw as $m) {
            $chartBulan[$m->month] = $m->total;
        }

        // b. Status Proyek
        $chartStatus = [
            'Selesai' => $kpi['proyek_selesai'],
            'Berjalan' => $kpi['proyek_berjalan'],
            'Tertunda' => $kpi['proyek_tertunda']
        ];

        // c. Realisasi vs Total (Simplified for chart)
        $chartRealisasi = [
            'Total Anggaran' => $kpi['total_anggaran'],
            'Total Realisasi' => $kpi['total_realisasi']
        ];

        // d. Proyek Berdasarkan Kategori
        $kategoriRaw = PembangunanProject::selectRaw('category, count(*) as total')->groupBy('category')->get();
        $chartKategori = ['labels' => [], 'data' => []];
        foreach($kategoriRaw as $k) {
            if ($k->category) {
                $chartKategori['labels'][] = $k->category;
                $chartKategori['data'][] = $k->total;
            }
        }

        // 4. Map Data (Latitude & Longitude)
        $mapData = $projects->whereNotNull('latitude')->whereNotNull('longitude')->map(function($p) {
            return [
                'name' => $p->name,
                'lat' => $p->latitude,
                'lng' => $p->longitude,
                'status' => $p->status,
                'progress' => $p->progress_percentage
            ];
        })->values();

        // 5. Informasi Terbaru (PDF/Docs)
        $recentDocs = PembangunanDocument::with('project')
            ->orderBy('upload_date', 'desc')
            ->limit(5)
            ->get();

        // 6. Dokumentasi Publik (Images)
        $publicDocs = PembangunanDocument::with('project')
            ->where('type', 'Image')
            ->orderBy('upload_date', 'desc')
            ->limit(3)
            ->get();

        // Get unique categories for filter
        $categories = PembangunanProject::select('category')->distinct()->pluck('category');

        return view('pembangunan.dashboard', compact(
            'projects', 'kpi', 'chartBulan', 'chartStatus', 'chartRealisasi', 
            'chartKategori', 'mapData', 'recentDocs', 'publicDocs', 'categories'
        ));
    }
}
