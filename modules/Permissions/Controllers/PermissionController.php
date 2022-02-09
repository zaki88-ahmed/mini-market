<?php

namespace modules\Permissions\Controllers;
use App\Http\Traits\ApiDesignTrait;
use Illuminate\Http\Request;
use modules\BaseController;
use modules\Permissions\Interfaces\PermissionInterface;
use modules\Permissions\Request\PermissionRequest;
use Spatie\Permission\Models\Permission;

class PermissionController extends BaseController
{
    use ApiDesignTrait;

    private $PermissionInterface;

    public function __construct(PermissionInterface $PermissionInterface)
    {
        $this->PermissionInterface = $PermissionInterface;
    }

     /**
     * @OA\Get (
     *     path="/api/permissions",
     *     summary="Show Permissions",
     *     description="Show Permissions",
     *     operationId="permissionShow",
     *     security={ {"sanctum": {} }} ,
     *     tags={"Permissions"},
     *     @OA\Response(
     *    response=200,
     *    description="Permissions",
     *    @OA\JsonContent(
     *       @OA\Property(property="data", type="object"),
     *        )
     *     ),
     * )
     */
    public function index(){
        $this->authorize('index',Permission::class);
        return $this->PermissionInterface->index();  
    }

     /**
     * @OA\Post(
     * path="/api/permissions/create",
     * summary="Create new Permission",
     * description="Create new Permission",
     * operationId="permissionCreate",
     * security={ {"sanctum": {} }} ,
     * tags={"Permissions"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Insert permission name",
     *    @OA\JsonContent(
     *       required={"name"},
     *       @OA\Property(property="name", type="string", format="text", example="create user"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Permission created successfully",
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
    public function create(PermissionRequest $request) {
        $this->authorize('create',Permission::class);
        $this->PermissionInterface->create($request);
    }

     /**
     * @OA\Put(
     * path="/api/permissions/{id}/edit",
     * summary="Update Permission",
     * description="Update Permission",
     * operationId="permissionEdit",
     * security={ {"sanctum": {} }} ,
     * tags={"Permissions"},
     * @OA\Parameter(
     *    description="ID of permission",
     *    in="path",
     *    name="id",
     *    required=true,
     *    example="1",
     * @OA\Schema(
     *       type="integer",
     *    ),
     * ),
     * @OA\RequestBody(
     *    required=true,
     *    description="update permission name",
     *    @OA\JsonContent(
     *       required={"name"},
     *       @OA\Property(property="name", type="string", format="text", example="create user"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Permission created successfully",
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
     */
    public function update(PermissionRequest $request,$permission_id){
        $this->authorize('update',Permission::class);
        $this->PermissionInterface->update($request, $permission_id);
    }

     /**
     * @OA\Delete (
     * path="/api/permissions/{id}/delete",
     * summary="Delete Permission",
     * description="Delete Permission",
     * operationId="permissionDelete",
     * security={ {"sanctum": {} }} ,
     * tags={"Permissions"},
     * @OA\Parameter(
     *    description="ID of permission",
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
     *    description="Permission Deleted successfully",
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
    public function delete($permission_id){
        $this->authorize('delete',Permission::class);
        $this->PermissionInterface->delete($permission_id);
    }
}
