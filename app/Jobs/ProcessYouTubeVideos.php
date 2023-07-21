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

class ProcessYouTubeVideos implements ShouldQueue
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
        foreach ($this->report->videos as $channelId => $videoIds) {
            $channel = Channel::findOrFail($channelId);

            foreach ($videoIds as $videoId) {
                $response = $service->getVideoById($videoId);

                $channel->videos()->create([
                    'video_id' => $response->getId(),
                    'total_views' => $response->getStatistics()->getViewCount(),
                    'total_likes' => $response->getStatistics()->getLikeCount(),
                    'total_comments' => $response->getStatistics()->getCommentCount(),
                    'details' => $response->getSnippet(),
                    'statistics' => $response->getStatistics(),
                ]);
            }
        }
    }
}
