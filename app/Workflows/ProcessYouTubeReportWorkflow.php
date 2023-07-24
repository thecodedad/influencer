<?php

namespace App\Workflows;

use App\Jobs\CalculateYouTubeMetrics;
use App\Jobs\ParseYouTubeChannelsUrls;
use App\Jobs\ProcessYouTubeChannels;
use App\Jobs\ProcessYouTubeVideos;
use App\Models\YouTube\Report;
use Sassnowski\Venture\AbstractWorkflow;
use Sassnowski\Venture\WorkflowDefinition;

class ProcessYouTubeReportWorkflow extends AbstractWorkflow
{
    public function __construct(protected Report $report)
    {
        //
    }

    public function definition(): WorkflowDefinition
    {
        $workflow = $this->define('Process YouTube Report');

        $workflow->addJob(new ParseYouTubeChannelsUrls($this->report));
        $workflow->addJob(new ProcessYouTubeChannels($this->report), [ ParseYouTubeChannelsUrls::class ]);
        $workflow->addJob(new ProcessYouTubeVideos($this->report), [ ProcessYouTubeChannels::class ]);
        $workflow->addJob(new CalculateYouTubeMetrics($this->report), [ ProcessYouTubeVideos::class ]);

        return $workflow;
    }
}
