<?php

namespace App\Policies;

use App\Models\User;

class StaffSuspensionPolicy
{
/**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view suspensions');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return $user->hasPermissionTo('suspend');
    }
}
