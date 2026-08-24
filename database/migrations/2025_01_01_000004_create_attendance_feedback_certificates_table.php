<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance', function (Blueprint $table) {
            $table->id('attendance_id');
            $table->foreignId('event_id')->constrained('events', 'event_id')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->boolean('attended')->default(false);
            $table->timestamp('marked_on')->nullable();
            $table->timestamps();

            $table->unique(['event_id', 'student_id']);
        });

        Schema::create('feedback', function (Blueprint $table) {
            $table->id('feedback_id');
            $table->foreignId('event_id')->constrained('events', 'event_id')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedTinyInteger('rating'); // 1-5
            $table->text('comments')->nullable();
            $table->enum('status', ['visible', 'flagged', 'removed'])->default('visible');
            $table->timestamp('submitted_on')->useCurrent();
        });

        Schema::create('certificates', function (Blueprint $table) {
            $table->id('certificate_id');
            $table->foreignId('event_id')->constrained('events', 'event_id')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->string('certificate_url');
            $table->boolean('fee_paid')->default(false); // stub only, no real payment gateway
            $table->timestamp('issued_on')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
        Schema::dropIfExists('feedback');
        Schema::dropIfExists('attendance');
    }
};
