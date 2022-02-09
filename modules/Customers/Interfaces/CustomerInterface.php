<?php
namespace modules\Customers\Interfaces;


interface CustomerInterface {

    public function register($request);
    public function login($request);
    public function logout();
    public function updatePassword($request);

    public function allCustomers();
    public function customerDetails();
    public function updateCustomer($request);

    public function softDeleteCustomer($request);
    public function restoreCustomer($request);
    public function verify($request, $id);

}
