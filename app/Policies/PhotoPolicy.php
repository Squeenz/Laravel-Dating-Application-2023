<?php

namespace App\Policies;

use App\Models\Photo;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PhotoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAdd(User $user): bool
    {
        return $user->hasPermissionTo('add photos');
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewRemove(User $user): bool
    {
        return $user->hasPermissionTo('remove photos');
    }


    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Photo $photo): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('add photos');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Photo $photo): bool
    {
        return $photo->user()->is($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Photo $photo): bool
    {
        return $this->update($user, $photo);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Photo $photo): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Photo $photo): bool
    {
        //
    }
}
