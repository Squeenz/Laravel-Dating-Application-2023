<?php

namespace App\Policies;

use App\Models\User;

class StaffVerifyUserPolicy
{
    public function viewEvidence(User $user): bool
    {
        return $user->hasPermissionTo('view identities');
    }

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view identities');
    }

    public function update(User $user): bool
    {
        return $user->hasPermissionTo('verify users');
    }
}
