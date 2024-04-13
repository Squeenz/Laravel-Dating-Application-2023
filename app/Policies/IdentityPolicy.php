<?php

namespace App\Policies;

use App\Models\Identity;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class IdentityPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('pending verification') && $user->identity;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('pending verification') && !$user->identity;
    }
}
