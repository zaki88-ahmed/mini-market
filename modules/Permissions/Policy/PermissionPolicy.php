<?php

namespace modules\Permissions\Policy;


use Illuminate\Auth\Access\HandlesAuthorization;
use modules\Admins\Models\Admin;
use Spatie\Permission\Models\Permission;


class PermissionPolicy
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

}
