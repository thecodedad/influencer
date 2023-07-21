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
        Schema::create('youtube_channels', function (Blueprint $table) {
            $table->id();
            $table->string('channel_id')->unique();
            $table->unsignedInteger('total_subscribers')->default(0);
            $table->unsignedInteger('total_videos')->default(0);
            $table->unsignedInteger('total_views')->default(0);
            $table->unsignedInteger('total_likes')->default(0);
            $table->unsignedInteger('total_comments')->default(0);
            $table->decimal('weekly_cadence', 5, 2)->default(0.00);
            $table->decimal('monthly_cadence', 5, 2)->default(0.00);
            $table->decimal('average_views', 5, 2)->default(0.00);
            $table->decimal('average_likes', 5, 2)->default(0.00);
            $table->decimal('average_comments', 5, 2)->default(0.00);
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
        Schema::dropIfExists('channels');
    }
};
