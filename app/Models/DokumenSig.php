<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenSig extends Model
{
    use HasFactory;

    protected $table = 'dokumen_sig';

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
