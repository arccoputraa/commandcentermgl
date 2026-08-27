<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KependudukanAgama extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun',
        'kecamatan',
        'kelurahan',
        'agama',
        'penduduk',
        'persentase',
        'status',
    ];
}
