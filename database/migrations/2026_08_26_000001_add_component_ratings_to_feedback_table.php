<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->unsignedTinyInteger('organizational_quality')->nullable()->after('rating');
            $table->unsignedTinyInteger('content_relevance')->nullable()->after('organizational_quality');
            $table->unsignedTinyInteger('venue_rating')->nullable()->after('content_relevance');
            $table->unsignedTinyInteger('coordination_rating')->nullable()->after('venue_rating');
            $table->unsignedTinyInteger('technical_arrangements')->nullable()->after('coordination_rating');
            $table->unsignedTinyInteger('hospitality_rating')->nullable()->after('technical_arrangements');
        });
    }

    public function down(): void
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->dropColumn([
                'organizational_quality',
                'content_relevance',
                'venue_rating',
                'coordination_rating',
                'technical_arrangements',
                'hospitality_rating',
            ]);
        });
    }
};
