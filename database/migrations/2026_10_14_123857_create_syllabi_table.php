<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('syllabi', function (Blueprint $table) {
            $table->id();
            $table->string('course_name');
            $table->string('course_code');
            $table->string('department');
            $table->string('program_type');
            $table->integer('credits');
            $table->string('instructor');
            $table->string('instructor_email')->nullable();
            $table->text('course_description');
            $table->json('learning_objectives');
            $table->json('course_outline'); // Week by week breakdown
            $table->json('assessment_methods'); // Assignments, exams, projects with weights
            $table->json('required_textbooks')->nullable();
            $table->json('recommended_readings')->nullable();
            $table->json('prerequisites')->nullable();
            $table->text('attendance_policy')->nullable();
            $table->text('grading_scale')->nullable();
            $table->text('late_policy')->nullable();
            $table->text('academic_integrity')->nullable();
            $table->string('semester');
            $table->year('academic_year');
            $table->string('schedule')->nullable(); // Days and times
            $table->string('location')->nullable();
            $table->string('office_hours')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('syllabus_file_path')->nullable(); // PDF download
            $table->timestamps();
            
            $table->index(['course_name', 'department']);
            $table->index(['semester', 'academic_year']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('syllabi');
    }
};
