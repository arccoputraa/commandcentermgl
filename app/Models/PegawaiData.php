<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiData extends Model
{
    use HasFactory;

    protected $table = 'pegawai_data';

    protected $fillable = [
        'nip', 'nama', 'jenis_pegawai', 'jenis_kelamin', 'jabatan', 'golongan', 'unit_kerja', 'status_pegawai', 'tanggal_bergabung'
    ];
}
