<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinanceSubBidang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_unit',
        'kode_unit',
        'deskripsi',
        'status',
        'jumlah_staff'
    ];
}
