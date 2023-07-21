<?php

namespace App\Jobs;

use App\Influencer\Services\YouTubeService;
use App\Models\YouTube\Channel;
use App\Models\YouTube\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessYouTubeChannels implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected Report $report)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(YouTubeService $service): void
    {
        foreach ($this->report->channels as $channelId) {
            $response = $service->getChannelById($channelId);

            $channel = Channel::create([
                'channel_id' => $response->id,
                'details' => $response->snippet,
                'statistics' => $response->statistics,
            ]);

            $response = $service->getVideosByChannel($channel->channel_id);

            $videos = [

            ];

            foreach ($videos as $video) {
                array_push($videos, $video->id->videoId);

                $video = $service->getVideoById($video->id->videoId);

                $channel->videos()->create([
                    'video_id' => $video->id,
                    'details' => $video->snippet,
                    'statistics' => $video->statistics,
                ]);
            }
        }
    }
}
