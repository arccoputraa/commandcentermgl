<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KependudukanInformasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'kategori',
        'file',
        'tanggal',
        'status',
    ];
}
