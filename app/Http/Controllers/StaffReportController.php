<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Policies\StaffReportPolicy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class StaffReportController extends Controller
{
    public function index(): Response
    {
        $this->authorize('viewAny', StaffReportController::class);

        $reports = Report::with('suspect', 'complainant')->get();

        return Inertia::render('Staff/Users/Reports', [
            'reports' => $reports,
        ]);
    }

    public function update(Report $report): RedirectResponse
    {
        $this->authorize('update', StaffReportController::class);

        $report->status = 1;
        $report->update();

        return redirect(route('staff.dashboard.reports'));
    }
}
