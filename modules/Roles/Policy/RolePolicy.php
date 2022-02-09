<?php

namespace modules\Roles\Policy;


use Illuminate\Auth\Access\HandlesAuthorization;
use modules\Admins\Models\Admin;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    use HandlesAuthorization;

    public function index(Admin $user)
    {
         return $user->hasRole('admin'); 
    }
    
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
    public function assignPremission(Admin $user )
    {
        return $user->hasRole('admin') ;
    }
}
