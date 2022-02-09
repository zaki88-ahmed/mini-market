<?php

namespace modules\Categories\Policy;


use Illuminate\Auth\Access\HandlesAuthorization;
use modules\Categories\Models\Category;
use modules\Admins\Models\Admin;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function create(Admin $user)
    {
         return $user->hasRole('admin'); 
    }

    public function update(Admin $user )
    {
        return $user->hasRole('admin') ;
    }


    public function delete(Admin $user )
    {
        return $user->hasRole('admin') ;
    }
    public function restore(Admin $user )
    {
        return $user->hasRole('admin') ;
    }
}
