<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UjiKir extends Model
{
    use HasFactory;

    protected $table = 'uji_kir';

    protected $fillable = [
        'tanggal_uji',
        'jenis_kendaraan',
        'status_uji',
        'unit_layanan',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_uji' => 'date',
    ];
}
