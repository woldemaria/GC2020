<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Syllabus extends Model
{
    protected $fillable = [
        'course_name',
        'course_code',
        'department',
        'program_type',
        'credits',
        'instructor',
        'instructor_email',
        'course_description',
        'learning_objectives',
        'course_outline',
        'assessment_methods',
        'required_textbooks',
        'recommended_readings',
        'prerequisites',
        'attendance_policy',
        'grading_scale',
        'late_policy',
        'academic_integrity',
        'semester',
        'academic_year',
        'schedule',
        'location',
        'office_hours',
        'is_active',
        'syllabus_file_path'
    ];

    protected $casts = [
        'learning_objectives' => 'array',
        'course_outline' => 'array',
        'assessment_methods' => 'array',
        'required_textbooks' => 'array',
        'recommended_readings' => 'array',
        'prerequisites' => 'array',
        'is_active' => 'boolean',
        'academic_year' => 'integer'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByDepartment($query, $department)
    {
        return $query->where('department', $department);
    }

    public function scopeByCourse($query, $course)
    {
        return $query->where('course_name', $course);
    }

    public function scopeBySemester($query, $semester, $year = null)
    {
        $query->where('semester', $semester);
        if ($year) {
            $query->where('academic_year', $year);
        }
        return $query;
    }

    public function getSyllabusDownloadUrlAttribute()
    {
        return $this->syllabus_file_path ? 
            asset('storage/' . $this->syllabus_file_path) : 
            null;
    }

    public function getFullCourseNameAttribute()
    {
        return $this->course_code ? 
            "{$this->course_code} - {$this->course_name}" : 
            $this->course_name;
    }

    public function getTotalAssessmentWeightAttribute()
    {
        if (!$this->assessment_methods) return 0;
        
        return collect($this->assessment_methods)->sum('weight');
    }
}
