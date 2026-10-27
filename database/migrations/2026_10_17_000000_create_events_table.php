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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('short_description')->nullable();
            $table->date('event_date');
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->string('location');
            $table->string('venue')->nullable();
            $table->string('image')->nullable();
            $table->string('category')->default('general'); // general, academic, ceremony, sports, cultural, workshop
            $table->unsignedInteger('max_attendees')->nullable();
            $table->unsignedInteger('registered_count')->default(0);
            $table->date('registration_deadline')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->json('requirements')->nullable(); // array of requirement strings
            $table->json('highlights')->nullable(); // array of highlight strings
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->text('organizer')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->index('slug');
            $table->index('event_date');
            $table->index('category');
            $table->index('is_published');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
