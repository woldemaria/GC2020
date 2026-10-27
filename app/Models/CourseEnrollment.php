<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseEnrollment extends Model
{
    protected $fillable = [
        'student_name',
        'student_email',
        'student_phone',
        'student_id',
        'course_name',
        'department',
        'program_type',
        'motivation',
        'prerequisites_met',
        'status',
        'admin_notes',
        'enrolled_at',
        'approved_at',
        'approved_by'
    ];

    protected $casts = [
        'prerequisites_met' => 'array',
        'enrolled_at' => 'datetime',
        'approved_at' => 'datetime'
    ];

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeByDepartment($query, $department)
    {
        return $query->where('department', $department);
    }

    public function scopeByCourse($query, $course)
    {
        return $query->where('course_name', $course);
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'yellow',
            'approved' => 'green',
            'rejected' => 'red',
            'waitlist' => 'blue',
            default => 'gray'
        };
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Pending Review',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'waitlist' => 'Waitlisted',
            default => 'Unknown'
        };
    }
}
