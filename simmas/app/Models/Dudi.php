<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dudi extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'pic_name',
        'status',
        'student_quota',
        'category',
        'teacher_id'
    ];

    

    /**
     * Get the internships for the DUDI.
     */
    public function internships()
    {
        return $this->hasMany(Internship::class);
    }

    /**
     * Get the teacher assigned to this DUDI.
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
