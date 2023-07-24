<?php

namespace App\Jobs;

use App\Models\YouTube\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Sassnowski\Venture\WorkflowStep;

class CalculateYouTubeMetrics implements ShouldQueue
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
    public function handle(): void
    {
        $this->report->channels->each(function ($channel) {
            $channel->videos->each(function ($video) {
                $video->update([
                    'total_engagement' => 1 - ($video->total_likes + $video->total_comments) / $video->total_views,
                ]);
            });

            $channel->total_likes = $channel->videos->sum('total_likes');
            $channel->total_comments = $channel->videos->sum('total_comments');

            $channel->total_engagement = 1 - ($channel->total_subscribers + $channel->total_likes + $channel->total_comments) / $channel->total_views;

            $channel->weekly_cadence = 1 - $channel->videos->groupBy(function ($video) {
                return Carbon::parse($video->published_at)->startOfWeek()->format('Y-m-d');
            })->count() / $channel->total_videos;

            $channel->monthly_cadence = 1 - $channel->videos->groupBy(function ($video) {
                return Carbon::parse($video->published_at)->startOfMonth()->format('Y-m-d');
            })->count() / $channel->total_videos;

            $channel->average_views = 1 - $channel->total_views / $channel->total_videos;
            $channel->average_likes = 1 - $channel->total_likes / $channel->total_videos;
            $channel->average_comments = 1 - $channel->total_comments / $channel->total_videos;

            $channel->view_comment_ratio = 1 - $channel->average_likes / $channel->total_views;
            $channel->view_engagement_ratio = 1 - $channel->average_comments / $channel->total_views;
            $channel->view_like_ratio = 1 - $channel->average_likes / $channel->total_views;

            $channel->save();
        });
    }
}
