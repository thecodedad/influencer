<?php

namespace App\Jobs;

use App\Influencer\Services\YoutubeService;
use App\Models\YouTube\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessYouTubeChannel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected string $channelId)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(YoutubeService $service): void
    {
        $channel = $service->getChannelById($this->channelId);

        $channel = Channel::create([
            'channel_id' => $channel->id,
            'details' => $channel->snippet,
            'statistics' => $channel->statistics,
        ]);

        $videos = $service->getVideosByChannel($channel->channel_id);

        foreach ($videos as $video) {
            ProcessYouTubeVideo::dispatch($channel, $video->id->videoId);
        }
    }
}
