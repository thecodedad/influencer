<?php

namespace App\Http\Controllers;

use App\Models\YouTube\Report;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function show(Report $report)
    {
        return Inertia::render('Reports/Show', [
            'report' => $report
        ]);
    }
}
