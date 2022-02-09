<?php
namespace modules\Roles\Interfaces;


interface RoleInterface {

    public function index();
    public function create($request);
    public function update($request, $role_id);
    public function delete($role_id);
    public function assignPermission($request, $role_id);



}
