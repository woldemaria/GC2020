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
        Schema::create('course_enrollments', function (Blueprint $table) {
            $table->id();
            $table->string('student_name');
            $table->string('student_email');
            $table->string('student_phone')->nullable();
            $table->string('student_id')->nullable();
            $table->string('course_name');
            $table->string('department');
            $table->string('program_type'); // Undergraduate, Graduate, Professional
            $table->text('motivation')->nullable();
            $table->json('prerequisites_met')->nullable(); // Track which prerequisites student has met
            $table->enum('status', ['pending', 'approved', 'rejected', 'waitlist'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamp('enrolled_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamps();
            
            $table->index(['student_email', 'course_name']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_enrollments');
    }
};
