<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReportController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', ReportController::class);

        $validated = $request->validate([
            'suspect' => 'required|integer',
            'complainant' => 'required|integer',
            'violated_rule' => ['required', Rule::in(['Harassment', 'Inappropriate Behavior', 'Impersonation', 'Scam or Fraud', 'Suspicious Activity', 'Stalking or Obsessive Behavior', 'Discrimination or Hate Speech', 'Privacy Violation'])],
            'extra_information' => 'nullable',
        ]);

        Report::create($validated);
    }
}
