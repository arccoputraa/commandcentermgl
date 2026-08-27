<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KependudukanWilayah extends Model
{
    use HasFactory;

    protected $table = 'kependudukan_wilayahs';

    protected $fillable = [
        'kecamatan',
        'kelurahan',
        'kode',
        'penduduk',
        'kk',
        'laki_laki',
        'perempuan',
        'status',
    ];
}
