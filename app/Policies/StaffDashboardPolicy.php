<?php

namespace App\Policies;

use App\Models\User;

class StaffDashboardPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return $user->hasAnyPermission(['access dashboard', 'access dashboard statistics']);
    }
}
