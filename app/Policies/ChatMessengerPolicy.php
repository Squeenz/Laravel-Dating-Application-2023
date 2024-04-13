<?php

namespace App\Policies;

use App\Models\User;

class ChatMessengerPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('use messages');
    }

    public function view(User $user): bool
    {
        return $user->hasPermissionTo('use messages');
    }

    public function update(User $user): bool
    {
        return $user->hasPermissionTo('use messages');
    }
}
