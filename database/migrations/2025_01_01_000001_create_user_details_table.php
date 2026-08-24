<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->id('detail_id');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('mobile', 15)->nullable();
            $table->string('department', 100)->nullable();
            $table->string('enrollment_no', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
