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
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('student_id')->unique();
            $table->string('email');
            $table->string('avatar')->nullable();
            $table->text('bio')->nullable();
            $table->string('major');
            $table->string('graduation_year');
            $table->string('gpa')->nullable();
            $table->json('achievements')->nullable(); // Array of achievements
            $table->json('interests')->nullable(); // Array of interests/hobbies
            $table->json('social_links')->nullable(); // Social media links
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};
