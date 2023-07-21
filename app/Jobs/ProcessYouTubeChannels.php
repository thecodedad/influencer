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
use Illuminate\Support\Carbon;
use Sassnowski\Venture\WorkflowStep;

class ProcessYouTubeChannels implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, WorkflowStep;

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
        $channels = [
            //
        ];

        foreach ($this->report->channels as $channelId) {
            $response = $service->getChannelById($channelId);

            $channel = $this->report->channels()->create([
                'channel_id' => $response->getId(),
                'total_subscribers' => $response->getStatistics()->getSubscriberCount() ?? 0,
                'total_videos' => $response->getStatistics()->getVideoCount() ?? 0,
                'total_views' => $response->getStatistics()->getViewCount() ?? 0,
                'details' => $response->getSnippet(),
                'statistics' => $response->getStatistics(),
                'published_at' => Carbon::parse($response->getSnippet()->getPublishedAt()),
            ]);

            $results = $service->getVideosByChannel($channel->channel_id);

            $videos = [

            ];

            foreach ($results as $video) {
                array_push($videos, $video->id->videoId);
            }

            $this->report->videos[$channel->id] = $videos;
            $this->report->save();
        }
    }
}
