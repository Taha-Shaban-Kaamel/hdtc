<?php

namespace App\Policies;

use App\Models\User;

class NotificationPolicy
{
    public function view(User $user)
    {
        return $user->hasPermissionTo('view-notifications');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('create-notifications');
    }

    public function update(User $user)
    {
        return $user->hasPermissionTo('edit-notifications');
    }

    public function delete(User $user)
    {
        return $user->hasPermissionTo('delete-notifications');
    }
}
