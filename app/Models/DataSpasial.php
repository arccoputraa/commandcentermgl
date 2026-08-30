<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSpasial extends Model
{
    use HasFactory;

    protected $table = 'data_spasial';

    protected $fillable = [
        'layer_id',
        'nama_data',
        'kategori',
        'wilayah',
        'nilai_jumlah',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'nilai_jumlah' => 'integer',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    public function layer()
    {
        return $this->belongsTo(LayerSig::class, 'layer_id');
    }
}
