<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    protected $fillable = [
        'name',
        'student_id',
        'email',
        'avatar',
        'bio',
        'motto',
        'major',
        'graduation_year',
        'gpa',
        'achievements',
        'interests',
        'social_links',
        'is_featured'
    ];

    protected $casts = [
        'achievements' => 'array',
        'interests' => 'array',
        'social_links' => 'array',
        'is_featured' => 'boolean'
    ];

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByGraduationYear($query, $year)
    {
        return $query->where('graduation_year', $year);
    }
}
