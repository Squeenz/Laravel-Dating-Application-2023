<?php

namespace App\Policies;

use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class StaffSupportTicketPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view tickets');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return $user->hasPermissionTo('update tickets');
    }

        /**
     * Determine whether the user can update the model.
     */
    public function updateHandlerStatus(User $user): bool
    {
        return $user->hasPermissionTo('self assing ticket');
    }
}
