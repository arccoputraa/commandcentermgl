<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KependudukanPenduduk extends Model
{
    use HasFactory;
    
    protected $table = 'kependudukan_penduduks';

    protected $fillable = [
        'tahun',
        'kecamatan',
        'kelurahan',
        'penduduk',
        'laki_laki',
        'perempuan',
        'wajib_ktp',
        'usia_produktif',
        'anak',
        'lansia',
        'kk',
        'agama',
        'status',
    ];
}
