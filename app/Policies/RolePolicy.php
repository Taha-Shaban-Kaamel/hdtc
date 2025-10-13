<?php

namespace App\Policies;

use App\Models\User;

class RolePolicy
{
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('view-roles', 'web');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('create-roles', 'web');
    }

    public function update(User $user)
    {
        return $user->hasPermissionTo('edit-roles', 'web');
    }

    public function delete(User $user)
    {
        return $user->hasPermissionTo('delete-roles', 'web');
    }
}
