<?php

namespace App\Policies;

use App\Models\Report;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReportPolicy
{
    /**
     * Determine whether the user can create the model.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create report');
    }
}
