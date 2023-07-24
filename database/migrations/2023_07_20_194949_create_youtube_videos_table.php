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
            $table->string('video_id');
            $table->unsignedInteger('total_views')->default(0);
            $table->unsignedInteger('total_likes')->default(0);
            $table->unsignedInteger('total_comments')->default(0);
            $table->decimal('total_engagement', 5, 2)->default(0.00);
            $table->schemalessAttributes('details');
            $table->schemalessAttributes('statistics');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
