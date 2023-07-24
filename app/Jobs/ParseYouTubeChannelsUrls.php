<?php

namespace App\Jobs;

use App\Models\YouTube\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Sassnowski\Venture\WorkflowStep;

class ParseYouTubeChannelsUrls implements ShouldQueue
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
        $this->report->data['channels'] = $this->parseChannels();
        $this->report->save();
    }

    /**
     * Parse the channels from the report file.
     */
    private function parseChannels(): array
    {
        return collect($this->report->data['channels'])->reduce(fn ($channels, $channelUrl) => array_merge($channels, [
            $channelUrl => $this->parseIdentifier($channelUrl)
        ]), []);
    }

    /**
     * Fetch the HTML source and parse the identifier from the meta tags.
     */
    public function parseIdentifier($channelUrl): string
    {
        $response = Http::get($channelUrl)->body();

        $document = new \DOMDocument();

        @$document->loadHTML($response);

        $meta = [
            //
        ];

        foreach ($document->getElementsByTagName('meta') as $tag) {
            $meta[$tag->getAttribute('itemprop')] = $tag->getAttribute('content');
        }

        return $meta['identifier'];
    }
}
