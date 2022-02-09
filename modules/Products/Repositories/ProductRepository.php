<?php

namespace modules\Products\Repositories;

use App\Http\Filter\FilterHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use modules\Products\Interfaces\ProductInterface;
use Symfony\Component\HttpFoundation\Response;
use modules\Products\Requests\ProductRequest;
use modules\Products\Models\Product;
use App\Http\Traits\ApiDesignTrait;
use Exception;

class ProductRepository implements ProductInterface
{

    use ApiDesignTrait;

    /**
     * @OA\Get(
     *      path="/api/products",
     *      operationId="index",
     *      tags={"Product"},
     *      summary="Get list of products",
     *      description="Returns list of product Data",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *         @OA\JsonContent(
     *              @OA\Property(property="products", type="object", ref="#/components/schemas/Product"),
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
     *     )
     */
    public function index($request)
    {
//        try {
//            $products = Product::simplePaginate(10);
//            return $this->ApiResponse(Response::HTTP_OK, null,Null,$products);
//        } catch (Exception $e) {
//            return $this->ApiResponse(Response::HTTP_NO_CONTENT, null,'No provided data ');
//        }

        $filter_conditions = $request->only(['keyword', 'category_ids', 'store_ids']);
        $query = FilterHelper::apply(Product::query(), $filter_conditions);
//        dd($query->get());
        $cashedProducts = Redis::get('products');
        if(isset($cashedProducts)){
            $data = json_decode($cashedProducts);
            return $this->ApiResponse(400, 'cashed', $data);
        }else{
//            $product = Product::all();
            $product = $query->get();
            Redis::set('products', $product);
            return $this->ApiResponse(400, 'All Products', null, $product);
        }
//        return Redis::get('products');
//        return Redis::del('products');

    }
    /**
     * @OA\Post(
     * path="/api/search",
     * summary="search",
     * description="Search for product",
     * operationId="search",
     * tags={"Product"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Search for product",
     *    @OA\JsonContent(
     *           required={"term"},
     *          @OA\Property(property="term", type="string", example = "iphone"),
     *    ),
     * ),
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *              @OA\Property(property="products", type="object", ref="#/components/schemas/Product"),
     *     )
     *  ),
     * @OA\Response(
     *    response=422,
     *    description="invalid input",
     *    @OA\JsonContent(
     *       @OA\Property(property="error", type="string", example="no such this product match try later")
     *        )
     *     )
     * )
     *
     */

    public function search($request)
    {
        try {
            $products = Product::with(['orders'])
                ->where('name', 'Like', '%' . $request->term . '%')
                ->orderBy('id', 'DESC')
                ->simplePaginate(10);
            if (is_null($products)) {
                return $this->ApiResponse(Response::HTTP_NOT_FOUND, null,"No Products match");
            }
            return $this->ApiResponse(Response::HTTP_CREATED, "most relevant products", null,$products);
        }catch (Exception $e)
        {
            return $this->ApiResponse(Response::HTTP_BAD_REQUEST, null,"Data format is invalid try again");
        }

    }
    /**
     * @OA\Post(
     * path="/api/products/create",
     * summary="new product",
     * description="store new product",
     * operationId="store",
     * tags={"Product"},
     * security={ {"sanctum": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="Store new product",
     *    @OA\JsonContent(
     *           required={"title","price"},
     *          @OA\Property(property="title", type="string", example = "iphone 12 pro"),
     *          @OA\Property(property="price", type="double", example = "111.00"),
     *           ),
     *      ),
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *         @OA\Property(property="message", type="string", example="product created")
     *     )
     *  ),
     * @OA\Response(
     *    response=422,
     *    description="invalid input",
     *    @OA\JsonContent(
     *       @OA\Property(property="error", type="string", example="product can't be created try later")
     *        )
     *     )
     * )
     *
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $product = Product::create($data);
//            $product->specs()->Sync($request->specs);
            return $this->ApiResponse(Response::HTTP_CREATED, "Product created successfully", null, $product);
        } catch (Exception $e) {
            return $this->ApiResponse(500, null,'Product can\'t be created, try later');
        }
    }

    /**
     * @OA\Get(
     *      path="/api/products/{product}",
     *      operationId="show",
     *      tags={"Product"},
     *      summary="Get specific product ",
     *      description="Returns specific product Data",
     *     @OA\Parameter(
     *          name="product",
     *          description="product id",
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
     *              @OA\Property(property="product", type="object", ref="#/components/schemas/Product"),
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
     *     )
     */
    public function show(Product $product)
    {
        if ($product->trashed()) {
            return $this->ApiResponse(Response::HTTP_NOT_FOUND, 'Product was deleted',null);
        }
        $product = Product::find($product->id);
        return $this->ApiResponse(Response::HTTP_OK,'show Product',null,$product);
    }
    /**
     * @OA\Post  (
     * path="/api/update/products",
     * summary="update existing product",
     * description="update product",
     * operationId="update",
     * tags={"Product"},
     * security={ {"sanctum": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="update product name",
     *    @OA\JsonContent(
     *           required={"title","price", "product_id"},
     *          @OA\Property(property="title", type="string", example = "iphone 12 pro"),
     *          @OA\Property(property="price", type="double", example = "111.00"),
     *          @OA\Property(property="product_id", type="integer",  example="1"),
     *     ),
     *     ),
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *         @OA\Property(property="product", type="object", ref="#/components/schemas/Product"),
     *         @OA\Property(property="message", type="string", example="product updated")
     *     )
     *  ),
     * @OA\Response(
     *    response=422,
     *    description="invalid input",
     *    @OA\JsonContent(
     *       @OA\Property(property="validation error", type="string", example="Sorry, invalid product name")
     *        )
     *     )
     * )
     *
     */

//    public function update(Product $product, Request $request)
//    {
////        dd('mmmm');
//        try {
//            $product->update($request->all());
////            $product->specs()->Sync($request->specs);
//            return $this->ApiResponse(Response::HTTP_ACCEPTED, 'Product updated', null, $product);
//        } catch (Exception $e) {
//            return $this->ApiResponse(500, 'Update process can not be complete, try later');
//        }
//    }

    public function update($request)
    {
//        dd($request->all());
//        print_r($request->all()); exit();

            $product = Product::find($request->product_id);
//            dd($product);
            $product->update([
                'product_id' => $request->product_id,
                'title' => $request->title,
                'price' => $request->price,
            ]);
            return $this->ApiResponse(200, 'Product updated', null, $product);

    }


    /**
     * @OA\Delete(
     *      path="/api/products/{product}",
     *      operationId="destroy",
     *      tags={"Product"},
     *      summary="Delete existing product",
     *      description="Delete existing product ",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="product",
     *          description="product id",
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
     *              @OA\Property(property="success", type="string", example="product Moved to trash")
     *           )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     *
     */

    public function destroy(Product $product)
    {
        if ($product->trashed()) {
            return $this->ApiResponse(Response::HTTP_NOT_FOUND, 'Product already deleted');
        }
        $product->delete();
        return $this->ApiResponse(Response::HTTP_MOVED_PERMANENTLY, 'Product Moved to trash...' );
    }





}
