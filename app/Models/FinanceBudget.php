<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinanceBudget extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun',
        'sub_bidang',
        'nama_anggaran',
        'total_anggaran',
        'total_realisasi',
        'periode',
        'status',
        'catatan_internal'
    ];
}
