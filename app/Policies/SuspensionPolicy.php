<?php

namespace App\Policies;

use App\Models\User;

class SuspensionPolicy
{
    public function view(User $user): bool
    {
        return $user->hasRole('suspended');
    }
}
