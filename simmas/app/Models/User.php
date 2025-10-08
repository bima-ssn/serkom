<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nis_nip',
        'phone',
        'kelas',
        'jurusan',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    /**
     * Normalize role to lowercase for consistent comparisons.
     */
    protected function role(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => is_string($value) ? strtolower(trim($value)) : $value,
            set: fn (mixed $value) => is_string($value) ? strtolower(trim($value)) : $value,
        );
    }
    
    /**
     * Get the internships where user is a teacher.
     */
    public function teacherInternships()
    {
        return $this->hasMany(Internship::class, 'teacher_id');
    }
    
    /**
     * Get the internship where user is a student.
     */
    public function studentInternship()
    {
        return $this->hasOne(Internship::class, 'student_id');
    }
    
    /**
     * Check if user is admin.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    
    /**
     * Check if user is teacher.
     */
    public function isTeacher()
    {
        return $this->role === 'guru';
    }
    
    /**
     * Check if user is student.
     */
    public function isStudent()
    {
        return $this->role === 'siswa';
    }
}
