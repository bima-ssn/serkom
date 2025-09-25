<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    protected $fillable = [
        'student_id',
        'teacher_id',
        'dudi_id',
        'status',
        'start_date',
        'end_date',
        'final_score'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the student that owns the internship.
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the teacher that supervises the internship.
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get the DUDI that owns the internship.
     */
    public function dudi()
    {
        return $this->belongsTo(Dudi::class);
    }

    /**
     * Get the journals for the internship.
     */
    public function journals()
    {
        return $this->hasMany(Journal::class);
    }
}
