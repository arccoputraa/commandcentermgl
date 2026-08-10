<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerizinanData extends Model
{
    use HasFactory;

    protected $table = 'perizinan_data';

    protected $fillable = [
        'no_dokumen',
        'nama_pemohon',
        'perizinan_jenis_id',
        'jenis_permohonan',
        'tanggal',
        'status',
        'lokasi_kecamatan',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function jenisIzin()
    {
        return $this->belongsTo(PerizinanJenis::class, 'perizinan_jenis_id');
    }
}
