<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class StaffReportController extends Controller
{
    public function index(): Response
    {
        $reports = Report::with('suspect', 'complainant')->get();

        return Inertia::render('Staff/Users/Reports', [
            'reports' => $reports,
        ]);
    }

    public function update(Report $report): RedirectResponse
    {
        $report->status = 1;
        $report->update();

        return redirect(route('staff.dashboard.reports'));
    }
}
