<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('certificate_number')->unique();
            $table->string('verification_code')->unique();
            $table->string('qr_code_path')->nullable();
            
            // Graduate Information
            $table->string('graduate_name');
            $table->string('student_id');
            $table->string('qualification');
            $table->string('department');
            $table->string('program');
            $table->date('graduation_date');
            $table->decimal('gpa', 4, 2)->nullable();
            $table->string('honors')->nullable(); // cum laude, magna cum laude, etc.
            
            // University Information
            $table->string('university_name')->default('GC University');
            $table->string('university_logo_path')->nullable();
            $table->text('university_address')->nullable();
            
            // Certificate Details
            $table->enum('certificate_type', ['diploma', 'degree', 'masters', 'phd', 'certificate']);
            $table->enum('language', ['english', 'amharic', 'both'])->default('english');
            $table->text('additional_notes')->nullable();
            
            // Digital Signature & Authentication
            $table->string('digital_signature_path')->nullable();
            $table->string('authorized_by')->nullable(); // Name of authorizing official
            $table->string('authorized_title')->nullable(); // Title of authorizing official
            $table->timestamp('issued_at');
            $table->timestamp('expires_at')->nullable();
            
            // Status & Verification
            $table->enum('status', ['active', 'revoked', 'expired'])->default('active');
            $table->integer('verification_count')->default(0);
            $table->timestamp('last_verified_at')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index(['certificate_number', 'status']);
            $table->index(['verification_code', 'status']);
            $table->index('graduate_name');
            $table->index('graduation_date');
            $table->index('department');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};