<?php

namespace App\Workflows;

use App\Jobs\ParseYouTubeChannels;
use App\Jobs\ProcessYouTubeChannels;
use App\Jobs\ProcessYouTubeVideos;
use App\Models\YouTube\Report;
use Sassnowski\Venture\Facades\Workflow;
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

        $workflow->addJob(new ParseYouTubeChannels($this->report));
        $workflow->addJob(new ProcessYouTubeChannels($this->report), [ ParseYouTubeChannels::class ]);
        $workflow->addJob(new ProcessYouTubeVideos($this->report), [ ProcessYouTubeChannels::class ]);

        return $workflow;
    }
}
