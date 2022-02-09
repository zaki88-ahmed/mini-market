<?php

namespace modules\Customers\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use modules\Admins\Interfaces\AdminInterface;
use modules\Admins\Models\Admin;
use modules\Customers\Models\Customer;
use phpDocumentor\Reflection\Types\True_;

class CustomerPolicy
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

    public function allCustomers(Admin $admin){
//        return $admin->hasRole('admin');
        return $admin->hasPermissionTo('view-customer');
    }

    public function updatePassword(){
        $customer = auth('sanctum')->user();
        if($customer) {
            return true;
        }
        return false;

    }

    public function updateCustomer(){
        $customer = auth('sanctum')->user();
        if($customer->hasPermissionTo('edit-customer')){
            return true;
        }
        return false;
    }

    public function CustomerDetails(){
        $customer = auth('sanctum')->user();
        if($customer->hasPermissionTo('view-customer')) {
            return true;
        }
        return false;
    }

    public function softDeleteCustomer(Admin $admin){
//        return $admin->hasRole('admin');
        return $admin->hasPermissionTo('delete-customer');
    }

    public function restoreCustomers(Admin $admin){
//        return $admin->hasRole('admin');
        return $admin->hasPermissionTo('restore-customer');
    }


}
