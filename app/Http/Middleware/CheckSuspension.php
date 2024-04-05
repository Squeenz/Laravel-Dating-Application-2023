<?php

namespace App\Http\Middleware;

use App\Models\Suspension;
use Closure;
use DateTime;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSuspension
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user) {
            $reports = $user->reportSuspect;

            $possibleSuspensions = [];

            // Collect IDs of reports with status 1
            foreach ($reports as $report) {
                if ($report->status === 1) {
                    $possibleSuspensions[] = $report->id;
                }
            }

            $suspensions = Suspension::whereIn('report', $possibleSuspensions)
                                      ->where('suspended', 1)
                                      ->get();

            $currentDateTime = new DateTime();

            $currentSuspension = null;

            foreach ($suspensions as $suspension) {
                $suspensionDate = new DateTime($suspension->to);

                // Check if suspension's 'to' date is later than the current suspension
                if (!$currentSuspension || $suspensionDate < $currentSuspension->to) {
                    $currentSuspension = $suspension;
                }
            }

            $filteredSuspensions = $currentSuspension;

            $filteredSuspensionsDate = new DateTime($filteredSuspensions->to);

            if ($currentDateTime < $filteredSuspensionsDate)
            {
                 return redirect(route('suspended.index'));
            }
        }

        return $next($request);
    }
}
