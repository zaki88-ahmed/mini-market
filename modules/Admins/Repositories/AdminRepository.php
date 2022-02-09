<?php

namespace modules\Admins\Repositories;

use Exception;
use Carbon\Carbon;
use modules\BaseRepository;
use modules\Admins\Models\Admin;
use App\Http\Traits\ApiDesignTrait;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use modules\Admins\Requests\StoreAdminRequest;
use modules\Admins\Requests\UpdateAdminRequest;
use modules\Admins\Requests\LoginAdminRequest;

class AdminRepository extends BaseRepository
{
    use ApiDesignTrait;

    /**
     * @OA\Post(
     * path="/api/admin/login",
     * summary="Login",
     * description="Login Admin and Create token",
     * operationId="login",
     * tags={"Admin"},
     * @OA\RequestBody(
     *    required=true,
     *    description="store admin data",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *     @OA\Property(property="email", type="email", format="email", example="admin@gmail.com"),
     *     @OA\Property(property="password", type="string", format="password", example="123456"),
     *        )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\Property(property="Admin", type="object", ref="Admin"),
     *     ),
     * @OA\Response(
     *    response=404,
     *    description="Returns when user not found",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Logedin"),
     *    )
     * )
     * )
     */

    public function login ($request)
    {
        $data = $request->all();
        return $this->auth('admin', $data);
    }

    /**
     * @OA\Get(
     *      path="/api/admins",
     *      operationId="index",
     *      tags={"Admin"},
     *      summary="Get list of Admins",
     *      description="Returns list of Admin  Data",
     *      security={ {"sanctum": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *         @OA\JsonContent(
     *              @OA\Property(property="admins", type="object", ref="#/components/schemas/Admin"),
     *          )
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     *     )
     */

    public function index()
    {
        try {
            $admins = Admin::get();
            return $this->ApiResponse(Response::HTTP_OK, 'message',Null,$admins);
        } catch (Exception $e) {
            return $this->ApiResponse(Response::HTTP_NO_CONTENT,null, 'No data provided');
        }
    }

    /**
     * @OA\Post(
     * path="/api/create/admins",
     * summary="create admin",
     * description="create new admin ",
     * operationId="store",
     * tags={"Admin"},
     * security={ {"sanctum": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="store new Admin name",
     *    @OA\JsonContent(
     *       required={"name","email","password","contact","country_id","city_id"},
     *     @OA\Property(property="name", type="string", example="Admin"),
     *     @OA\Property(property="email", type="string", format="email", example="Admin@gmail.com"),
     *     @OA\Property(property="password", type="string",example="password12345"),
     *     @OA\Property(property="contact", type="string", example="01234567891"),
     *     @OA\Property(property="country_id", type="integer", example="2"),
     *     @OA\Property(property="city_id", type="integer" ,example="4"),
     *     @OA\Property(property="role", type="integer" ,example="admin"),
     *        ),
     * ),
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *         @OA\Property(property="message", type="string", example="Admin created")
     *     )
     *  ),
     * @OA\Response(
     *    response=422,
     *    description="invalid input",
     *    @OA\JsonContent(
     *       @OA\Property(property="error", type="string", example="Admin can't be created try later")
     *        )
     *     )
     * )
     *
     */

    public function store(StoreAdminRequest $request)
    {
        $data = $request->all();
        try{
            $admin = Admin::create([
            'name' => $data['name'],
            'contact' => $data['contact'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'created_at' => Carbon::now(),
            'country_id' => $data['country_id'],
            'city_id' => $data['city_id']
            ]);
            $admin->assignRole($data['role']);

        } catch (Exception $e) {
            return $this->ApiResponse(Response::HTTP_NO_CONTENT, 'can not create Admin try later');
        }
        return $this->ApiResponse(Response::HTTP_OK,'Admin Created Successfully',null,$admin);
    }

    /**
     * @OA\Get(
     *      path="/api/admins/{admin}",
     *      operationId="show",
     *      tags={"Admin"},
     *      summary="Get Admin profile",
     *      description="Returns Admins profile Data",
     *      security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *          name="admin",
     *          description="Admin id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *         @OA\JsonContent(
     *              @OA\Property(property="admin", type="object", ref="#/components/schemas/Admin"),
     *          )
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function show(Admin $admin)
    {
        try{
            $profile = Admin::with(['city','country'])->find($admin->id);
        }catch (Exception $e) {
            return $this->ApiResponse(Response::HTTP_NOT_FOUND, null, 'can not Find Admin Data');
        }
        return $this->ApiResponse(Response::HTTP_OK,null,null,$profile);
    }

    /**
     * @OA\Put (
     * path="/api/admins/{admin}",
     * summary="update existing admin",
     * description="update admin",
     * operationId="update",
     * tags={"Admin"},
     * security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *          name="admin",
     *          description="admin id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     * @OA\RequestBody(
     *    required=true,
     *    description="update admin ",
     *    @OA\JsonContent(
     *       required={"email","country_id","city_id","password"},
     *     @OA\Property(property="name", type="string", example="Admin"),
     *     @OA\Property(property="email", type="string", format="email", example="Admin@gmail.com"),
     *     @OA\Property(property="password", type="string",example="password12345"),
     *     @OA\Property(property="contact", type="string", example="01234567891"),
     *     @OA\Property(property="country_id", type="integer", example="2"),
     *     @OA\Property(property="city_id", type="integer" ,example="4"),
     *     @OA\Property(property="role", type="integer" ,example="admin"),
     *    ),
     * ),
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *         @OA\Property(property="message", type="string", example="category updated")
     *     )
     *  ),
     * @OA\Response(
     *    response=422,
     *    description="invalid input",
     *    @OA\JsonContent(
     *       @OA\Property(property="validation error", type="string", example="Sorry, invalid category name")
     *        )
     *     )
     * )
     *
     */
    public function update(Admin $admin, UpdateAdminRequest $request)
    {
        try{
            $data = $request->all();
            $admin->update([
                'name' => $data['name'],
                'contact' => $data['contact'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'updated_at' => Carbon::now(),
                'country_id' => $data['country_id'],
                'city_id' => $data['city_id']
            ]);
            $admin->assignRole($data['role']);
        } catch (Exception $e) {
            return $this->ApiResponse(Response::HTTP_BAD_REQUEST,null,' something error try again later');
        }
        return $this->ApiResponse(Response::HTTP_OK,'Profile Updated successfully',null);
    }

    /**
     * @OA\Delete(
     *      path="/api/admins/{admin}",
     *      operationId="destroy",
     *      tags={"Admin"},
     *      summary="Delete existing Admin",
     *      description="Deletes a Admin and returns no Message",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="admin",
     *          description="Admin id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example="Admin Moved to trash")
     *           )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     *
     */

    public function destroy(Admin $admin)
    {
        if ($admin->trashed()) {
            return $this->ApiResponse(Response::HTTP_NOT_FOUND, 'this Admin was deleted previously ');
        }
        try{
            $admin->delete();
        } catch (Exception $e) {
            return $this->ApiResponse(Response::HTTP_BAD_REQUEST,null,' something error try again later');
        }
        return $this->ApiResponse(Response::HTTP_MOVED_PERMANENTLY, 'account Moved to trash...' );
    }

    /**
     * @OA\Post(
     * path="/api/logout",
     * summary="Logout",
     * description="Logout Admin and delete token",
     * operationId="logout",
     * tags={"Admin"},
     * security={ {"sanctum": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Success"
     *     ),
     * @OA\Response(
     *    response=401,
     *    description="Returns when user is not authenticated",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Logedout"),
     *    )
     * )
     * )
     */

    public function logout()
    {
        $admin = auth('sanctum')->user();
        $admin->tokens()->where('id', $admin->currentAccessToken()->id)->delete();
        return $this->ApiResponse(Response::HTTP_OK, 'Admin logged out', null);
    }

    public function notFound()
    {
        return $this->ApiResponse(Response::HTTP_NOT_FOUND, null, 'THIS ADMIN NOT EXIST.');

    }

}
