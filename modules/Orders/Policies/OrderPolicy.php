<?php

namespace modules\Orders\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use modules\Admins\Models\Admin;
use modules\Customers\Models\Customer;
use modules\Products\Models\Product;

class OrderPolicy
{
    use HandlesAuthorization;

    public function store()
    {
        $customer = auth('sanctum')->user();
        if($customer->hasPermissionTo('create-order')) {
           return true;
      }
       return false;
    }
//
//    public function update(Admin $user, Product $product)
//    {
//
////        return  $user->can('edit-product');
////        return  $user->hasPermissionTo('edit-product');
//        return true;
//    }
//
//    public function delete(Admin $user, Product $product)
//    {
//        return $user->can('delete-product');
//    }

//    public function allProducts(Admin $admin){
////        return $admin->hasRole('admin');
//    return $admin->hasPermissionTo('view-customer');
//}


    public function updateOrder(){
        $customer = auth('sanctum')->user();
        if($customer->hasPermissionTo('update-order')) {
            return true;
        }
        return false;
    }

//    public function ProductDetails(){
//        $customer = auth('sanctum')->user();
//        if($customer->hasPermissionTo('view-customer')) {
//            return true;
//        }
//        return false;
//    }
    public function allOrders(Admin $admin){
        return $admin->hasPermissionTo('view-order');
    }



    public function OrderDetails(){
        $customer = auth('sanctum')->user();
        if($customer->hasPermissionTo('view-order')) {
            return true;
        }
        return false;
    }


    public function softDeleteOrder(){
       $customer = auth('sanctum')->user();
        if($customer->hasPermissionTo('delete-order')) {
            return true;
        }
        return false;
    }

    public function restoreOrder(){
        $customer = auth('sanctum')->user();
        if($customer->hasPermissionTo('restore-order')) {
            return true;
        }
        return false;
    }





}
