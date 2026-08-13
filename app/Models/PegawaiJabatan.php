<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiJabatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_jabatan', 'kode_unit', 'jabatan_utama', 'deskripsi_unit', 'eselon', 'jumlah_pegawai', 'status'
    ];
}
