<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id('registration_id');
            $table->foreignId('event_id')->constrained('events', 'event_id')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->enum('status', ['confirmed', 'cancelled', 'waitlist'])->default('confirmed');
            $table->string('qr_code')->unique()->nullable();
            $table->timestamp('registered_on')->useCurrent();
            $table->timestamps();

            $table->unique(['event_id', 'student_id']);
        });

        Schema::create('event_seating', function (Blueprint $table) {
            $table->foreignId('event_id')->primary()->constrained('events', 'event_id')->cascadeOnDelete();
            $table->unsignedInteger('total_seats');
            $table->unsignedInteger('seats_booked')->default(0);
            $table->boolean('waitlist_enabled')->default(true);
            $table->timestamps();
        });

        Schema::create('event_waitlist', function (Blueprint $table) {
            $table->id('waitlist_id');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('event_id')->constrained('events', 'event_id')->cascadeOnDelete();
            $table->timestamp('waitlist_time')->useCurrent();
            $table->enum('status', ['waiting', 'confirmed', 'cancelled'])->default('waiting');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_waitlist');
        Schema::dropIfExists('event_seating');
        Schema::dropIfExists('registrations');
    }
};
