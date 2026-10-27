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
        Schema::table('photos', function (Blueprint $table) {
            // Enhanced gallery features
            $table->integer('likes')->default(0);
            $table->integer('dislikes')->default(0);
            $table->year('graduation_year')->nullable();
            $table->string('motto')->nullable();
            $table->string('student_name')->nullable();
            $table->string('department')->nullable();
            $table->string('degree_program')->nullable();
            $table->string('photographer')->nullable();
            $table->json('tags')->nullable();
            $table->enum('photo_type', ['graduation', 'event', 'campus', 'student_life', 'academic', 'sports', 'other'])->default('other');
            $table->boolean('allow_comments')->default(true);
            $table->boolean('is_public')->default(true);
            $table->unsignedBigInteger('uploaded_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->text('admin_notes')->nullable();
            
            // Indexes for better performance
            $table->index('graduation_year');
            $table->index('photo_type');
            $table->index('is_public');
            $table->index('likes');
        });
    }

    public function down(): void
    {
        Schema::table('photos', function (Blueprint $table) {
            $table->dropColumn([
                'likes', 'dislikes', 'graduation_year', 'motto', 'student_name', 
                'department', 'degree_program', 'photographer', 'tags', 'photo_type',
                'allow_comments', 'is_public', 'uploaded_by', 'approved_at', 
                'approved_by', 'admin_notes'
            ]);
        });
    }
};
