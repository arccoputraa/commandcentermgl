<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenPerhubungan extends Model
{
    use HasFactory;

    protected $table = 'dokumen_perhubungan';

    protected $fillable = [
        'judul',
        'file_path',
        'status_tag',
        'tanggal_rilis',
    ];

    protected $casts = [
        'tanggal_rilis' => 'date',
    ];
}
