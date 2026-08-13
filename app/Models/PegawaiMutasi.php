<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiMutasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nip', 'nama_pegawai', 'jenis', 'tanggal_efektif', 'keterangan', 'status_pengajuan'
    ];
}
