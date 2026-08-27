<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembangunanProjectProgress extends Model
{
    use HasFactory;

    protected $table = 'pembangunan_project_progresses';

    protected $fillable = [
        'project_id',
        'report_date',
        'progress_percentage',
        'realized_budget'
    ];

    protected $casts = [
        'report_date' => 'date',
    ];

    public function project()
    {
        return $this->belongsTo(PembangunanProject::class, 'project_id');
    }
}
