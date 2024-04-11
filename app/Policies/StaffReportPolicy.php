<?php

namespace App\Policies;

use App\Models\User;

class StaffReportPolicy
{
    /**
     * Create a new policy instance.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view reports');
    }

    public function update(User $user) : bool
    {
        return $user->hasPermissionTo('close report');
    }
}
