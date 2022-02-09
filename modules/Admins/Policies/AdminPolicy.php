<?php

namespace modules\Admins\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use modules\Admins\Models\Admin;
use Spatie\Permission\Models\Role;

class AdminPolicy
{
    use HandlesAuthorization;

    public function viewAny(Admin $user)
    {
        return $user->can('viewAny_admin');
    }

    public function view(Admin $user, Admin $admin)
    {
        return  $user->can('view_admin');
    }

    public function delete(Admin $user)
    {
        return  $user->can('delete_admin');
    }
}
