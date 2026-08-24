<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id('event_id');
            $table->string('title', 150);
            $table->text('description');
            $table->string('category', 50); // technical, cultural, sports, seminar, etc.
            $table->date('event_date');
            $table->time('event_time');
            $table->string('venue', 100);
            $table->foreignId('organizer_id')->constrained('users')->cascadeOnDelete();
            $table->string('banner_image')->nullable();
            $table->string('rulebook')->nullable();
            $table->unsignedInteger('max_participants')->default(0);
            $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled'])->default('pending');
            $table->boolean('waitlist_enabled')->default(true);
            $table->boolean('cancellation_allowed')->default(true);
            $table->date('cancellation_cutoff')->nullable();
            $table->decimal('certificate_fee', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
