<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificate_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('certificate_id')->constrained()->onDelete('cascade');
            $table->string('verifier_ip')->nullable();
            $table->string('verifier_user_agent')->nullable();
            $table->string('verification_method'); // 'qr_code', 'manual_code', 'certificate_number'
            $table->json('verification_details')->nullable(); // Additional verification metadata
            $table->timestamp('verified_at');
            $table->timestamps();
            
            $table->index(['certificate_id', 'verified_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificate_verifications');
    }
};