<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinanceInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'kategori',
        'format',
        'dokumen',
        'keterangan',
        'status_publikasi'
    ];
}
