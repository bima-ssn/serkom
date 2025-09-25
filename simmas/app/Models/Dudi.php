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
        'status'
    ];

    /**
     * Get the internships for the DUDI.
     */
    public function internships()
    {
        return $this->hasMany(Internship::class);
    }
}
