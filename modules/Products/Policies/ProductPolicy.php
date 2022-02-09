<?php

namespace modules\Products\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use modules\Admins\Models\Admin;
use modules\Customers\Models\Customer;
use modules\Products\Models\Product;

class ProductPolicy
{
    use HandlesAuthorization;

    public function store(Admin $admin)
    {
//        $admin->hasRole('admin');
        return $admin->hasPermissionTo('create-product');
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


    public function updateProduct(Admin $admin){
        return $admin->hasPermissionTo('update-product');
    }

//    public function ProductDetails(){
//        $customer = auth('sanctum')->user();
//        if($customer->hasPermissionTo('view-customer')) {
//            return true;
//        }
//        return false;
//    }

    public function softDeleteProduct(Admin $admin){
//        return $admin->hasRole('admin');
        return $admin->hasPermissionTo('delete-product');
    }

    public function restoreProduct(Admin $admin){
//        return $admin->hasRole('admin');
        return $admin->hasPermissionTo('restore-product');
    }





}
