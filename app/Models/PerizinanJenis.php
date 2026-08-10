<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerizinanJenis extends Model
{
    use HasFactory;

    protected $table = 'perizinan_jenis';

    protected $fillable = [
        'jenis_izin',
        'kategori',
        'sla',
        'status',
        'dokumen',
        'keterangan',
    ];

    public function dataPerizinan()
    {
        return $this->hasMany(PerizinanData::class, 'perizinan_jenis_id');
    }
}
