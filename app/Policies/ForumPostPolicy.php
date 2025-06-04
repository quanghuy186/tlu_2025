<?php

namespace App\Policies;

use App\Models\ForumPost;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ForumPostPolicy
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
    public function view(User $user, ForumPost $forumPost): bool
    {
        return tluHasPermission($user, 'show-anonymously');
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
    public function update(User $user, ForumPost $forumPost): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ForumPost $forumPost): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ForumPost $forumPost): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ForumPost $forumPost): bool
    {
        return false;
    }
}
