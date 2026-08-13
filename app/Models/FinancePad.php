<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancePad extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun',
        'sumber_pendapatan',
        'sub_bidang',
        'target_pad',
        'realisasi_pad',
        'periode',
        'status',
        'catatan_internal'
    ];

    protected $appends = ['persentase'];

    public function getPersentaseAttribute()
    {
        if ($this->target_pad > 0) {
            return round(($this->realisasi_pad / $this->target_pad) * 100);
        }
        return 0;
    }
}
