<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KependudukanMutasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun',
        'bulan',
        'kecamatan',
        'kelurahan',
        'kelahiran',
        'kematian',
        'pindah_datang',
        'pindah_keluar',
        'status',
    ];
}
