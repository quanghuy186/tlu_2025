<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserHasRole;
use Illuminate\Auth\Access\Response;

class UserHasRolePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, UserHasRole $userHasRole): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, UserHasRole $userHasRole): Response
    {
        $hasPermissionChucNang = tluHasPermission($user, $userHasRole);
        $hasPermissionDuLieu = $user->id == $userHasRole->id;
        
        if (!$hasPermissionChucNang || !$hasPermissionDuLieu) {
            return Response::deny("Bạn không có quyền");
        }
        
        return Response::allow();
    }


    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, UserHasRole $userHasRole): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, UserHasRole $userHasRole): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, UserHasRole $userHasRole): bool
    {
        return false;
    }
}
