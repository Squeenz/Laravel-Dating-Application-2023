<?php

namespace App\Http\Controllers;

use App\Models\Suspension;
use DateTime;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class SuspensionController extends Controller
{
    public function index()
    {
        $this->authorize('view', SuspensionController::class);

        $user = Auth::user();

        $reports = $user->reportSuspect;

        $mostRecentReport = null;

        foreach ($reports as $report)
        {
            $reportCreatedDate = new DateTime($report->created_at);

            if ($report->status === 1 && (!$mostRecentReport || $reportCreatedDate < $mostRecentReport->created_at))
            {
                $mostRecentReport = $report;
            }
        }

        if(!$mostRecentReport)
        {
            return redirect(route('matchmaking'));
        }

        $suspension = Suspension::where('report', '=', $mostRecentReport->id)->first();

        return Inertia::render('Suspended', [
            'report' => $mostRecentReport,
            'suspension' => $suspension,
        ]);
    }
}
