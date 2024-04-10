<?php

namespace App\Policies;

use App\Models\Page;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PagePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view pages controller');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('add page controller');
    }

    /**
     * Determine whether the user can update each specific page
     */
    public function updateSpecificPage(User $user, Page $page): bool
    {
        return $user->hasAnyPermission(['view page', 'add page component', 'edit page component', 'delete page component']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Page $page): bool
    {
        return $user->hasPermissionTo('edit page controller');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Page $page): bool
    {
        return $user->hasPermissionTo('delete page controller');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Page $page): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Page $page): bool
    {
        //
    }
}
