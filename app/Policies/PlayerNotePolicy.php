<?php

namespace App\Policies;

use App\Enums\Permissions;
use App\Enums\Roles;
use App\Models\User;

class PlayerNotePolicy
{
    /**
     * Determine whether the user can view any models.
     * 
     * @param User  $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole([Roles::AGENT->value, Roles::VIEWER->value])
            && $user->hasPermissionTo(Permissions::VIEW_PLAYER_NOTES->value);
    }

    /**
     * Determine whether the user can create models.
     * 
     * @param User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasRole(Roles::AGENT->value)
            && $user->hasPermissionTo(Permissions::CREATE_PLAYER_NOTES->value);
    }
}
