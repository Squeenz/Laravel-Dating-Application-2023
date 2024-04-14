<?php

namespace App\Http\Controllers;

use App\Models\Identity;
use Illuminate\Http\RedirectResponse;
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
        $this->authorize('viewEvidence', StaffVerifyUserController::class);

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
        $this->authorize('viewAny', StaffVerifyUserController::class);

        $identities = Identity::with('user')->get();

        return Inertia::render('Staff/Users/Verify', [
            'identities' => $identities,
        ]);

    }

    public function update(Request $request, Identity $identity, string $status): RedirectResponse
    {
        $this->authorize('update', StaffVerifyUserController::class);

        $identity->valid = $status;
        $identity->update();

        $user = $identity->user()->get()->first();

        if ($status === '2')
        {
            $user->syncRoles('user');
        }
        else if ($status === '1')
        {
            $user->syncRoles('pending verification');
        }

        return redirect()->back();
    }
}
