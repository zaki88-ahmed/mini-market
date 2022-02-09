<?php
namespace modules\Categories\Controllers;


use App\Http\Traits\ApiDesignTrait;
use modules\BaseController;
use modules\Categories\Interfaces\CategoryInterface;
use modules\Categories\Models\Category;
use modules\Categories\Request\CategoryRequest;
use modules\Categories\Request\UpdateCategory;

class CategoryController extends BaseController
{
    use ApiDesignTrait;

    private $CategoryInterface;

    public function __construct(CategoryInterface $CategoryInterface)
    {
        $this->CategoryInterface = $CategoryInterface;
    }


    /**
     * @OA\Get (
     *     path="/api/categories/all",
     *     summary="Show Categories",
     *     description="Show Categories",
     *     operationId="categoriesShow",
     *     tags={"CategoryCRUD"},
     *     security={ {"sanctum": {} }} ,
     *    @OA\Response(
     *     response=200,
     *     description="all Category ",
     *     @OA\JsonContent(
     *        @OA\Property(property="name", type="object", ref="#/components/schemas/Category"),
     *
     *     )
     *  )
     * )
     */
    public function index()
    {
        return $this->CategoryInterface->index();
    }


     /**
     * @OA\Post(
     * path="/api/categories/create",
     * summary="Create Category",
     * description="Create Using name",
     * operationId="CategoryCreate",
     * tags={"CategoryCRUD"},
     *security={ {"sanctum": {} }} ,
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass category name",
     *    @OA\JsonContent(
     *       required={"name"},
     *       @OA\Property(property="name", type="string", format="text", example="Action"),
     *       @OA\Property(property="parent_id", type="integer", format="text", example="0"),
     *       @OA\Property(property="persistent", type="boolean", example="true"),
     *    ),
     * ),
     * @OA\Response(
     *     response=200,
     *     description="new Category add successfully",
     *     @OA\JsonContent(
     *        @OA\Property(property="name", type="object", ref="#/components/schemas/Category"),
     *     )
     *  ),
     * @OA\Response(
     *     response=403,
     *     description="Unauthenticated",
     *      @OA\JsonContent(
     *         @OA\Property(property="message", type="string", format="text", example="You Are Not Authorized!"),
     *       )
     *  ),
     * @OA\Response(
     *    response=422,
     *    description="Category Must be String",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, Category Required. Please try again")
     *        )
     *     )
     * )
     *
     */
    public function create(CategoryRequest $request)
    {
       // $category =Category::find(8);
       // $user = auth('sanctum')->user();
       //$this->authorizeForUser($user, 'create', $category);
       $this->authorize('create', Category::class);
      return  $this->CategoryInterface->create($request);
    }

     /**
     * @OA\Post(
     * path="/api/categories/update/{id}",
     * summary="Update Category",
     * description="Update Using name",
     * operationId="CategoryUpdate",
     * tags={"CategoryCRUD"},
     * security={ {"sanctum": {} }} ,
     * @OA\Parameter(
     *          description="ID of categories",
     *          in="path",
     *          name="id",
     *          required=true,
     *          example="2",
     * ),
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass category name",
     *    @OA\JsonContent(
     *       required={"name"},
     *       @OA\Property(property="name", type="string", format="text", example="Action"),
     *       @OA\Property(property="parent_id", type="integer", format="text", example="0"),
     *       @OA\Property(property="persistent", type="boolean", example="true"),
     *    ),
     * ),
     * @OA\Response(
     *     response=200,
     *     description="new Category updated successfully",
     *     @OA\JsonContent(
     *        @OA\Property(property="name", type="object", ref="#/components/schemas/Category"),
     *     )
     *  ),
     * @OA\Response(
     * response=403,
     * description="Unauthenticated",
     * @OA\JsonContent(
     *   @OA\Property(property="message", type="string", format="text", example="You Are Not Authorized!"),
     *   )
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Category Must be String",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, Category Required. Please try again")
     *        )
     *     )
     * )
     *
     */
    public function update(UpdateCategory $request,$cat_id)
    {
        $this->authorize('update',Category::class);
       return $this->CategoryInterface->update($request, $cat_id);
    }

     /**
     * @OA\Post (
     * path="/api/categories/delete/{id}",
     * summary="Delete Category",
     * description="Delete Category",
     * operationId="categoryDelete",
     * tags={"CategoryCRUD"},
     * security={ {"sanctum": {} }} ,
     * @OA\Parameter(
     *    description="ID of category",
     *    in="path",
     *    name="id",
     *    required=true,
     *    example="2",
     * @OA\Schema(
     *       type="integer",
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Category Deleted successfully",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", format="text", example="Category deleted successfully"),
     *        )
     *     ),
     * @OA\Response(
     * response=403,
     * description="Unauthenticated",
     * @OA\JsonContent(
     *   @OA\Property(property="message", type="string", format="text", example="You Are Not Authorized!"),
     *   )
     * ),
     * @OA\Response(
     *    response=422,
     *    description="The given data was invalid.",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="The given data was invalid."),
     *        )
     *     )
     * )
     */
    public function delete($cat_id)
    {
      $this->authorize('delete',Category::class);
      return  $this->CategoryInterface->delete($cat_id); 
    }

     /**
     * @OA\Post(
     *      path="/api/categories/restore/{id}",
     *      operationId="restore specific Category",
     *      tags={"CategoryCRUD"},
     *      summary="Restore delete Category",
     *      description="restore Category",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *     description="ID of category",
     *     in="path",
     *     name="id",
     *     required=true,
     *     example="5",
     *     @OA\Schema(
     *       type="integer",
     *      ),
     *    ),
     *      @OA\Response(
     *          response=200,
     *          description="Category restored successfully",
     *      @OA\JsonContent(
     *       @OA\Property(property="message", type="string", format="text", example="Category restored successfully"),
     *        )
     *       ),
      *    @OA\Response(
     *     response=403,
     *     description="Unauthenticated",
     *     @OA\JsonContent(
     *      @OA\Property(property="message", type="string", format="text", example="You Are Not Authorized!"),
     *     )
     *    ),
     *  )
     */
    public function restore($cat_id) {
        $this->authorize('restore',Category::class);
        return $this->CategoryInterface->restore($cat_id);
    }

     
    /**
     * @OA\get(
     *      path="/api/categories/restore-all",
     *      operationId="restore All Category",
     *      tags={"CategoryCRUD"},
     *      summary="Restore All delete Category",
     *      description="restore All Category",
     *     security={ {"sanctum": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="All Category restored",
     *      @OA\JsonContent(
     *       @OA\Property(property="message", type="string", format="text", example="All Category restored successfully"),
     *        )
     *       ),
      *    @OA\Response(
     *     response=403,
     *     description="Unauthenticated",
     *     @OA\JsonContent(
     *      @OA\Property(property="message", type="string", format="text", example="You Are Not Authorized!"),
     *     )
     *    ),
     *  )
     */

    public function restoreAll(){
        return $this->CategoryInterface->restoreAll();
    }
}
?>
