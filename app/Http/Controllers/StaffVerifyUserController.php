<?php

namespace App\Http\Controllers;

use App\Models\Identity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class StaffVerifyUserController extends Controller
{
    /**
 * Get the link to the img
 */
    public function getPrivateEvidence($fileName)
    {
        $filePath = '/evidence/'. $fileName;

        if (Storage::disk('private')->exists($filePath))
        {
            return response()->file(storage_path("app/private/{$filePath}"));
        }
        else
        {
            abort(404);
        }
    }


    public function index(): Response
    {
        $identities = Identity::with('user')->get();

        return Inertia::render('Staff/Users/Verify', [
            'identities' => $identities,
        ]);
    }

    public function update(Request $request, Identity $identity, string $status)
    {
        //add policy
        $identity->valid = $status;
        $identity->update();
    }
}
