<?php

namespace App\Policies;

use App\Models\Matching;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MatchingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('use matchmaking');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return $user->hasPermissionTo('use matchmaking');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return $user->hasPermissionTo('use matchmaking');
    }
}
