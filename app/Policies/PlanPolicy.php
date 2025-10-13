<?php

namespace App\Policies;

use App\Models\User;

class PlanPolicy
{
    public function view(User $user)
    {
        return $user->hasPermissionTo('view-plans');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('create-plans');
    }

    public function update(User $user)
    {
        return $user->hasPermissionTo('edit-plans');
    }

    public function delete(User $user)
    {
        return $user->hasPermissionTo('delete-plans');
    }
}
