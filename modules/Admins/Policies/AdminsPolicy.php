<?php

namespace modules\Admins\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use modules\Admins\Interfaces\AdminInterface;
use modules\Admins\Models\Admin;
use modules\Customers\Models\Customer;
use phpDocumentor\Reflection\Types\True_;

class AdminsPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function allAdmins(Admin $admin){
//        return $admin->hasRole('admin');
        return $admin->hasPermissionTo('view-admin');
    }

//    public function updatePassword(Customer $vendor){
//        $customer = auth('sanctum')->user();
//        if($customer) {
//            return true;
//        }
//        return false;
//
//    }

//    public function updateCustomer(){
//        $customer = auth('sanctum')->user();
//        if($customer->hasPermissionTo('edit_vendor')){
//            return true;
//        }
//        return false;
//    }

    public function AdminDetails(Customer $vendor){
        $admin = auth('sanctum')->user();
        if($admin->hasPermissionTo('view-admin')) {
            return true;
        }
        return false;
    }

    public function softDeleteAdmin(Admin $admin){
//        return $admin->hasRole('admin');
        return $admin->hasPermissionTo('delete-admin');
    }

    public function restoreAdmin(Admin $admin){
//        return $admin->hasRole('admin');
        return $admin->hasPermissionTo('restore-admin');
    }


}
