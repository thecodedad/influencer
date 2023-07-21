<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class ParseYouTubeChannel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected string $channelUrl)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $response = Http::get($this->channelUrl)->body();

        $document = new \DOMDocument();

        @$document->loadHTML($response);

        $meta = [];

        foreach ($document->getElementsByTagName('meta') as $tag) {
            $meta[$tag->getAttribute('itemprop')] = $tag->getAttribute('content');
        }

        ProcessYouTubeChannel::dispatch($meta['identifier']);
    }
}
