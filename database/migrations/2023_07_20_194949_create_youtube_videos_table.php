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
        Schema::create('youtube_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\YouTube\Channel::class)->constrained('youtube_channels');
            $table->string('video_id')->unique();
            $table->unsignedInteger('total_subscribers');
            $table->unsignedInteger('total_videos');
            $table->unsignedInteger('total_views');
            $table->unsignedInteger('total_likes');
            $table->unsignedInteger('total_comments');
            $table->schemalessAttributes('details');
            $table->schemalessAttributes('statistics');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};