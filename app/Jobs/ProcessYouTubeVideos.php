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
use Sassnowski\Venture\WorkflowStep;

class ProcessYouTubeVideos implements ShouldQueue
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
        foreach ($this->report->videos as $channelId => $videoIds) {
            $channel = Channel::findOrFail($channelId);

            foreach ($videoIds as $videoId) {
                $response = $service->getVideoById($videoId);

                $channel->videos()->create([
                    'video_id' => $response->getId(),
                    'total_views' => $response->getStatistics()->getViewCount() ?? 0,
                    'total_likes' => $response->getStatistics()->getLikeCount() ?? 0,
                    'total_comments' => $response->getStatistics()->getCommentCount() ?? 0,
                    'details' => $response->getSnippet(),
                    'statistics' => $response->getStatistics(),
                    'published_at' => $response->getSnippet()->getPublishedAt(),
                ]);
            }
        }
    }
}
