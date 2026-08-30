<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayerSig extends Model
{
    use HasFactory;

    protected $table = 'layer_sig';

    protected $fillable = [
        'nama_layer',
        'status_aktif',
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
    ];

    public function dataSpasial()
    {
        return $this->hasMany(DataSpasial::class, 'layer_id');
    }
}
