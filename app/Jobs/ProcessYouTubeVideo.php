<?php

namespace App\Jobs;

use App\Influencer\Services\YoutubeService;
use App\Models\YouTube\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessYouTubeVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected Channel $channel, protected string $videoId)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(YoutubeService $service): void
    {
        $video = $service->getVideoById($this->videoId);

        $this->channel->videos()->create([
            'video_id' => $video->id,
            'details' => $video->snippet,
            'statistics' => $video->statistics,
        ]);
    }
}
