<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembangunanDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'pembangunan_project_id', 'title', 'type', 'file_path', 'upload_date', 'status_tag', 'description'
    ];

    public function project()
    {
        return $this->belongsTo(PembangunanProject::class, 'pembangunan_project_id');
    }

    public function getStorageUrlAttribute()
    {
        if ($this->file_path) {
            return \Illuminate\Support\Facades\Storage::url($this->file_path);
        }
        return null;
    }
}
