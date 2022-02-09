<?php
namespace modules\Permissions\Interfaces;


interface PermissionInterface {

    public function index();
    public function create($request);
    public function update($request, $permission_id);
    public function delete($permission_id);
}
