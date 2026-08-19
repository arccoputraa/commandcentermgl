<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KesehatanInformasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'file_pdf',
    ];
}
