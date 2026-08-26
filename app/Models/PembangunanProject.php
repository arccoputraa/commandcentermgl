<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembangunanProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_code', 'name', 'category', 'kecamatan', 'kelurahan',
        'total_budget', 'realized_budget', 'progress_percentage',
        'status', 'latitude', 'longitude'
    ];

    public function documents()
    {
        return $this->hasMany(PembangunanDocument::class);
    }

    public function progress()
    {
        return $this->hasMany(PembangunanProjectProgress::class, 'project_id');
    }
}
