<?php

namespace modules\Roles\Controllers;

use Illuminate\Http\Request;
use modules\BaseController;
use modules\Roles\Interfaces\RoleInterface;
use modules\Roles\Request\RoleRequest;
use Spatie\Permission\Models\Role;


class RoleController extends BaseController
{

    private $roleInterface;

    public function __construct(RoleInterface $roleInterface)
    {
        $this->roleInterface = $roleInterface;
    } 

       /**
     * @OA\Get (
     *     path="/api/roles",
     *     summary="Show Role",
     *     description="Show Roles",
     *     operationId="roleShow",
     *     security={ {"sanctum": {} }} ,
     *     tags={"Roles"},
     *     @OA\Response(
     *    response=200,
     *    description="Roles",
     *    @OA\JsonContent(
     *       @OA\Property(property="data", type="object"),
     *        )
     *     ),
     * )
     */
    public function index(){
        $this->authorize('index',Role::class);
        return $this->roleInterface->index();  
    }
    /**
     * @OA\Post(
     * path="/api/roles/create",
     * summary="Create new Role",
     * description="Create new Role",
     * operationId="roleCreate",
     * security={ {"sanctum": {} }} ,
     * tags={"Roles"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Insert role name",
     *    @OA\JsonContent(
     *       required={"name"},
     *       @OA\Property(property="name", type="string", format="text", example="admin"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Role created successfully",
     *    @OA\JsonContent(
     *       @OA\Property(property="data", type="object"),
     *        )
     *     ),
     *     @OA\Response(
     *    response=422,
     *    description="The given data was invalid.",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="The given data was invalid."),
     *       @OA\Property(property="errors", type="object"),
     *        )
     *     )
     * )
     */
    public function create(RoleRequest $request) {
        $this->authorize('create',Role::class);
      return  $this->roleInterface->create($request);
    }


    /**
     * @OA\Put (
     *     path="/api/roles/{id}/edit",
     *     summary="Edit Role",
     *     description="Edit Role",
     *     tags={"Roles"},
     *     operationId="roleEdit",
     *    security={ {"sanctum": {} }} ,
     *     @OA\Parameter(
     *          description="ID of role",
     *          in="path",
     *          name="id",
     *          required=true,
     *          example="1",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *      ),
     *     @OA\RequestBody (
     *          required=true,
     *          description="Role updated successfully",
     *     @OA\JsonContent(
     *       required={"name"},
     *       @OA\Property(property="name", type="string", format="text", example="admin"),
     *      ),
     *      ),
     *     @OA\Response(
     *    response=200,
     *    description="Role updated successfully",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Permission created successfully"),
     *       @OA\Property(property="status", type="string", example="Success"),
     *       @OA\Property(property="data", type="object"),
     *        )
     *     ),
     * @OA\Response(
     *    response=422,
     *    description="The given data was invalid.",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="The given data was invalid."),
     *       @OA\Property(property="errors", type="object"),
     *        )
     *     )
     * )
     * */
    public function update(RoleRequest $request,$role_id){
        $this->authorize('update',Role::class);
       return $this->roleInterface->update($request, $role_id);
    }

    /**
     * @OA\Delete (
     * path="/api/roles/{id}/delete",
     * summary="Delete Role",
     * description="Delete Role",
     * security={ {"sanctum": {} }} ,
     * operationId="roleDelete",
     * tags={"Roles"},
     * @OA\Parameter(
     *    description="ID of role",
     *    in="path",
     *    name="id",
     *    required=true,
     *    example="1",
     * @OA\Schema(
     *       type="integer",
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Role Deleted successfully",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", format="text", example="Permission deleted successfully"),
     *        )
     *     ),
     * @OA\Response(
     *    response=422,
     *    description="The given data was invalid.",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="The given data was invalid."),
     *       @OA\Property(property="errors", type="object"),
     *        )
     *     )
     * )
     */
    public function delete($role_id){
        $this->authorize('delete',Role::class);
       return $this->roleInterface->delete($role_id);
    }
    /**
     * @OA\Post(
     * path="/api/roles/{id}/assign-permissions",
     * summary="Assign permission to role",
     * description="Assign permission to role",
     * operationId="assignPermission",
     * security={ {"sanctum": {} }} ,
     * tags={"Roles"},
     *  @OA\Parameter (
     *     description="ID of role",
     *     in="path",
     *     name="id",
     *     required=true,
     *     example="1",
     * ),
     * @OA\RequestBody(
     *    required=true,
     *    description="Insert permission id",
     *    @OA\JsonContent(
     *       required={"permissions"},
     *       @OA\Property(
     *     property="permissions",
     *     type="array",
     *     collectionFormat="multi",
     *      @OA\Items(
     *            type="number"
     *       ),
     *       ),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Permissions assigned to the role",
     *    @OA\JsonContent(
     *       @OA\Property(property="data", type="object"),
     *        )
     *     ),
     *     @OA\Response(
     *    response=422,
     *    description="The given data was invalid.",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="The given data was invalid."),
     *       @OA\Property(property="errors", type="object"),
     *        )
     *     )
     * )
     */

     public function assignPermission(Request $request, $role_id){
        $this->authorize('assignPremission',Role::class);
        return $this->roleInterface->assignPermission($request,$role_id);
     }
}
