<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media_gallery', function (Blueprint $table) {
            $table->id('media_id');
            $table->foreignId('event_id')->constrained('events', 'event_id')->cascadeOnDelete();
            $table->enum('file_type', ['image', 'video']);
            $table->string('file_url');
            $table->foreignId('uploaded_by')->constrained('users')->cascadeOnDelete();
            $table->string('caption', 150)->nullable();
            $table->enum('status', ['visible', 'flagged', 'removed'])->default('visible');
            $table->timestamp('uploaded_on')->useCurrent();
        });

        // Admin -> system-wide or role-targeted announcements
        Schema::create('announcements', function (Blueprint $table) {
            $table->id('announcement_id');
            $table->foreignId('sent_by')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('message');
            $table->enum('target_role', ['all', 'participant', 'organizer'])->default('all');
            $table->foreignId('event_id')->nullable()->constrained('events', 'event_id')->nullOnDelete();
            $table->timestamps();
        });

        // Simple bookmarks for participants
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id('bookmark_id');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('event_id')->constrained('events', 'event_id')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['user_id', 'event_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookmarks');
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('media_gallery');
    }
};
