<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KependudukanKartuKeluarga extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun',
        'kecamatan',
        'kelurahan',
        'kk',
        'penduduk',
        'rata_rata',
        'status',
    ];
}
