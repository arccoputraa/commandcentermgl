<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembangunanDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'pembangunan_project_id', 'title', 'type', 'file_path', 'upload_date'
    ];

    public function project()
    {
        return $this->belongsTo(PembangunanProject::class, 'pembangunan_project_id');
    }
}
