<?php

namespace App\Policies;

use App\Models\User;

class AdminPolicy
{
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('view-admins', 'web');
    }
    
    public function create(User $user)
    {
        return $user->hasPermissionTo('create-admins', 'web');
    }
    
    public function update(User $user)
    {
        return $user->hasPermissionTo('edit-admins', 'web');
    }
    
    public function delete(User $user)
    {
        return $user->hasPermissionTo('delete-admins', 'web');
    }
}
