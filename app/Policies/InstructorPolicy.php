<?php

namespace App\Policies;

use App\Models\User;

class InstructorPolicy
{
    public function view(User $user)
    {
        return $user->hasPermissionTo('view-instructors');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('create-instructors');
    }

    public function update(User $user)
    {
        return $user->hasPermissionTo('edit-instructors');
    }

    public function delete(User $user)
    {
        return $user->hasPermissionTo('delete-instructors');
    }
}
