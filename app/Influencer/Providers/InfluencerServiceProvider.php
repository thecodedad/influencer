<?php

namespace App\Influencer\Providers;

use App\Influencer\Services\YoutubeService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class InfluencerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        App::bind(YoutubeService::class, function () {
            return new \App\Influencer\Services\YoutubeService(
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
