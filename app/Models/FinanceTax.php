<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FinanceTax extends Model
{
    use HasFactory;

    protected $fillable = [
        'bulan',
        'tahun',
        'jenis_pajak',
        'kecamatan',
        'kelurahan',
        'jumlah_pendapatan',
        'keterangan'
    ];
}
