<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Pagination\Paginator::defaultView('vendor.pagination.admin');
        if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Auto Cache Invalidation saat Admin mengubah/menghapus data sektoral
        $sectoralModels = [
            \App\Models\PerizinanData::class,
            \App\Models\PerizinanPublikasi::class,
            \App\Models\PegawaiData::class,
            \App\Models\PegawaiMutasi::class,
            \App\Models\FinanceBudget::class,
            \App\Models\FinancePad::class,
            \App\Models\FinanceTax::class,
            \App\Models\PembangunanProject::class,
            \App\Models\KesehatanPenyakit::class,
            \App\Models\UjiKir::class,
            \App\Models\DataSpasial::class,
            \App\Models\KependudukanPenduduk::class,
            \App\Models\KependudukanAgama::class,
            \App\Models\KependudukanMutasi::class,
        ];

        foreach ($sectoralModels as $modelClass) {
            if (class_exists($modelClass)) {
                $modelClass::saved(fn () => \Illuminate\Support\Facades\Cache::flush());
                $modelClass::deleted(fn () => \Illuminate\Support\Facades\Cache::flush());
            }
        }
    }
}
