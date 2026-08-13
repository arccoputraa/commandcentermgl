<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiInformasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul', 'kategori', 'format', 'dokumen', 'status_publikasi', 'keterangan'
    ];
}
