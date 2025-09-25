<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $fillable = [
        'internship_id',
        'date',
        'description',
        'status',
        'teacher_notes',
        'documentation_path'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Get the internship that owns the journal.
     */
    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }
}
