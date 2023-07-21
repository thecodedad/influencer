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
                $video = $service->getVideoById($videoId);

                $channel->videos()->create([
                    'video_id' => $video->id,
                    'details' => $video->snippet,
                    'statistics' => $video->statistics,
                ]);
            }
        }
    }
}
