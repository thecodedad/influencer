<?php

namespace App\Influencer\Providers;

use App\Influencer\Services\YouTubeService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class InfluencerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        App::bind(YouTubeService::class, function () {
            return new \App\Influencer\Services\YouTubeService(
                key: config('services.google.key')
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
