<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'task',
        'paid',
        'start_datetime',
        'end_datetime',
    ];

    public function projects()
    {
        return $this->belongsTo(Project::class);
    }
}
