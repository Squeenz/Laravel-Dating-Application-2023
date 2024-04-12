<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class StaffUserController extends Controller
{
    public function index(): Response
    {
        $this->authorize('viewAny', StaffUserController::class);

        $users = User::paginate(15);
        return Inertia::render('Staff/Users/Users', [
            'users' => $users,
        ]);
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        $user->delete();

        return redirect()->back();
    }
}
