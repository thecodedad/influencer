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
        Schema::create('channels', function (Blueprint $table) {
            $table->id();
            $table->string('channel_id')->unique();
            $table->schemalessAttributes('details');
            $table->schemalessAttributes('meta');
            $table->schemalessAttributes('branding');
            $table->schemalessAttributes('statistics');
            $table->schemalessAttributes('status');
            $table->schemalessAttributes('topics');
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