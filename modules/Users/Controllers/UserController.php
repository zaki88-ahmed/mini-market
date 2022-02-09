<?php
namespace modules\Users\Controllers;

use modules\BaseController;
use Illuminate\Http\Request;
use App\Http\Traits\ApiDesignTrait;
use modules\Users\Requests\UserRequest;
use modules\Users\Interfaces\UserInterface;
use modules\Users\Requests\UserLoginRequest;
use modules\Users\Requests\UpdatePasswordRequest;


class UserController extends BaseController
{
    use ApiDesignTrait;

    private $userInterface;

    public function __construct(UserInterface $user)
    {
//        $this->middleware(['auth', 'verified']);
        $this->userInterface = $user;
    }

    public function register(UserRequest $request)
    {
        return $this->userInterface->userRegister($request);
    }

    public function login(UserLoginRequest $request) {

        return $this->userInterface->userLogin($request);
    }
    public function logout() {

        return $this->userInterface->userLogout();
    }
    public function updatePassword(UpdatePasswordRequest $request) {

        return $this->userInterface->updatePassword($request);
    }
    public function getAllUsers() {
        return $this->userInterface->getAllUsers();
    }
    public function showUserById(Request $request) {
        return $this->userInterface->showUserById($request);
    }
}
