<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerizinanPublikasi extends Model
{
    use HasFactory;

    protected $table = 'perizinan_publikasi';

    protected $fillable = [
        'judul',
        'kategori',
        'format',
        'status',
        'dokumen',
        'keterangan',
    ];
}
