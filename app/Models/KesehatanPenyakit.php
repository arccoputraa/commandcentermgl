<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KesehatanPenyakit extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jumlah',
        'tahun',
        'bulan',
        'wilayah',
        'status',
    ];
}
