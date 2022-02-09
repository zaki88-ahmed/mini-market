<?php
namespace modules\Users\Interfaces;


interface UserInterface {

    public function userRegister($request);
    public function userLogin($request);
    public function userLogout();
    public function updatePassword($request);
    public function getAllUsers();
    public function showUserById($request);
}
