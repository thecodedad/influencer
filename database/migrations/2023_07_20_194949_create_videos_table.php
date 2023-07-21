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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\YouTube\Channel::class)->constrained();
            $table->schemalessAttributes('details');
            $table->schemalessAttributes('meta');
            $table->schemalessAttributes('player');
            $table->schemalessAttributes('recording');
            $table->schemalessAttributes('statistics');
            $table->schemalessAttributes('status');
            $table->schemalessAttributes('streaming');
            $table->schemalessAttributes('topics');
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
