<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserHasPermission;
use Illuminate\Auth\Access\Response;

class UserHasPermissionPolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, UserHasPermission $userHasPermission): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, UserHasPermission $userHasPermission): bool
    {
        return false;
    }

    public function delete(User $user, UserHasPermission $userHasPermission): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, UserHasPermission $userHasPermission): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, UserHasPermission $userHasPermission): bool
    {
        return false;
    }
}
