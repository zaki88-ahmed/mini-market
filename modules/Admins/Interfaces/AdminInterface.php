<?php
namespace modules\Admins\Interfaces;


use modules\Admins\Models\Admin;
use modules\Admins\Requests\AdminFormRequest;
use modules\Admins\Requests\LoginAdminRequest;
use modules\Admins\Requests\StoreAdminRequest;
use modules\Admins\Requests\UpdateAdminRequest;

interface AdminInterface {

    public function login (AdminFormRequest $request);

    public function index();



    public function show (Admin $admin);

    public function destroy (Admin $admin);

    public function logout ();
}
