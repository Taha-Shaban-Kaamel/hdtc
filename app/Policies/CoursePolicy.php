<?php

namespace App\Policies;

use App\Models\User;

class CoursePolicy
{

    public function viewAny(User $user)
    {
        return $user->can('view-courses');
    }
    
    public function create(User $user)
    {
        return $user->can('create-courses');
    }
    
    public function update(User $user)
    {
        return $user->can('edit-courses');  
    }
    
    public function delete(User $user)
    {
        return $user->can('delete-courses');
    }
}
