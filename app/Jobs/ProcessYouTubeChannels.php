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
                'channel_id' => $response->getId(),
                'total_subscribers' => $response->getStatistics()->getSubscriberCount(),
                'total_videos' => $response->getStatistics()->getVideoCount(),
                'total_views' => $response->getStatistics()->getViewCount(),
                'details' => $response->getSnippet(),
                'statistics' => $response->getStatistics(),
            ]);

            $response = $service->getVideosByChannel($channel->channel_id);

            $videos = [

            ];

            foreach ($videos as $video) {
                array_push($videos, $video->id->videoId);
            }

            $this->report->videos[$channel->channel_id] = $videos;
            $this->report->save();
        }
    }
}
