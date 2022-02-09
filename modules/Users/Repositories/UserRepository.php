<?php

namespace modules\Users\Repositories;

use modules\BaseRepository;
use modules\Users\Models\User;
use App\Http\Traits\ApiDesignTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use modules\Users\Interfaces\UserInterface;

class UserRepository extends BaseRepository implements UserInterface
{
    use ApiDesignTrait;

    /**
     * @OA\Post(
     * path="/api/users/register",
     * summary="register",
     * description="register by name , email and password",
     * operationId="authLogin",
     * tags={"Authentication"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Fill your Data",
     *    @OA\JsonContent(
     *       required={"name", "email","password"},
     *       @OA\Property(property="name", type="string", example="User"),
     *       @OA\Property(property="email", type="string", format="email", example="user@gmail.com"),
     *       @OA\Property(property="password", type="string", format="password", example="12345678"),
     *    ),
     * ),
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
     *     )
     *  ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     *
     */
    public function userRegister($request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return $this->ApiResponse(200, 'You have signed-in');
    }

    /**
     * @OA\Post(
     * path="/api/users/login",
     * summary="Sign in",
     * description="Login by email and password",
     * operationId="authLogin",
     * tags={"Authentication"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="string", format="email", example="user@mail.com"),
     *       @OA\Property(property="password", type="string", format="password", example="12345678"),
     *       @OA\Property(property="persistent", type="boolean", example="true"),
     *    ),
     * ),
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
     *     )
     *  ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     */
    public function userLogin($request)
    {
        $user = User::where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return $this->ApiResponse(401, 'Bad credentials');
        } elseif (is_null($user->email_verified_at)) {
            return $this->ApiResponse(401, 'please verify your email');
        }
        $login = $user->createToken('token-name')->plainTextToken;
        if ($login) {
            $response = ['token' => $login];
            return $this->ApiResponse(200, 'Done', null, $response);
        }
    }

    /**
     * @OA\Post(
     * path="/api/users/logout",
     * summary="Logout",
     * description="Logout by email, password",
     * operationId="authLogout",
     * tags={"Authentication"},
     * security={ {"sanctum": {} }},
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
     *     )
     *  ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     */
    public function userLogout()
    {
        $user = auth('sanctum')->user();
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        return $this->ApiResponse(200, 'Logged out');
    }

    /**
     * @OA\Post(
     *      path="/api/users/update-password",
     *      operationId="update password",
     *      tags={"Authentication"},
     *      summary="Update password",
     *      description="Update password",
     *     security={ {"sanctum": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass user credentials",
     *          @OA\JsonContent(
     *              required={"old_password", "new_password"},
     *              @OA\Property(property="old_password", type="string", format="old_password", example="12345678"),
     *              @OA\Property(property="new_password", type="string", format="new_password", example="123456789"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Password update successfully",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *        @OA\Response(
     *          response=400,
     *          description="Validation Error"
     *      )
     *     )
     */
    public function updatePassword($request)
    {
        User::find(auth('sanctum')->user()->id)->update(['password' => Hash::make($request->new_password)]);

        return $this->apiResponse(200, 'Password updated successfully');
    }

    /**
     * @OA\Get(
     *      path="/api/users",
     *      operationId="get all users",
     *      tags={"Users"},
     *      summary="Get list of users",
     *      description="Returns list of users",
     *     security={ {"sanctum": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="All users",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function getAllUsers()
    {
        $users = User::all();
        return $this->ApiResponse(200, 'All Users', NULL, $users);
    }

    /**
     * @OA\Get(
     *      path="/api/users/show",
     *      operationId="show specific User",
     *      tags={"Users"},
     *      summary="show specific user",
     *      description="show specific user",
     *     security={ {"sanctum": {} }},
     *   @OA\Parameter(
     *    name="user_id",
     *    in="query",
     *    required=true,
     *    description="Enter User id",
     *    ),
     *      @OA\Response(
     *          response=200,
     *          description="User details",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *        @OA\Response(
     *          response=400,
     *          description="Validation Error"
     *      )
     *     )
     */

    public function showUserById($request)
    {
        $validation = Validator::make($request->all(), ['user_id' => 'required|exists:users,id']);
        if ($validation->fails()) {
            return $this->ApiResponse(400, 'Validation Error', $validation->errors());
        }
        $user = User::where(['id', $request->user_id])->first();
        if (is_null($user)) {
            return $this->ApiResponse(400, 'no user found');
        }
        $user = User::find($request->user_id)->first();
        return $this->ApiResponse(200, 'User details', null, $user);
    }

}
