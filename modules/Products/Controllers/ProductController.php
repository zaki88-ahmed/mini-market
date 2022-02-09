<?php


namespace modules\Products\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use modules\Products\Repositories\ProductRepository;
use modules\Products\Requests\productFormRequest;
use modules\Products\Requests\ProductRequest;
use modules\Products\Models\Product;
use modules\BaseController;
use modules\Products\Requests\StoreProductRequest;
use modules\Products\Requests\UpdateProductRequest;


class ProductController extends BaseController
{

    private $repo;

    public function __construct(ProductRepository $productRepository)
    {
        $this->repo = $productRepository;
    }


    public function index(Request $request) {
        return $this->repo->index($request);
//        $cashed = Redis::get('products');
//        if(isset($cashed)){
//            $data = json_decode($cashed);
//            return $this->ApiResponse(400, 'cashed', $data);
//        }else{
//            $product = Product::all();
//            Redis::set('products', $product);
//            return $this->ApiResponse(400, 'All Products', null, $product);
//        }
//        return Redis::get('products');
//        return Redis::del('products');
    }

    public function store(productFormRequest $request)
    {
//        $admin = auth('sanctum')->user();
//        $this->authorize('store', Product::class);
        return $this->repo->store($request);
    }

//    public function update(Product $product, Request $request)
//    {
//        dd($request->all());
//        $user = auth('sanctum')->user();
//        $this->authorizeForUser($user,'update', $product);
//        $this->authorize('update', $product);
//        return $this->repo->update($product,$request);
//    }


    public function update(productFormRequest $request)
    {
//        dd($request->all());
//        $user = auth('sanctum')->user();
//        $this->authorizeForUser($user,'update', $product);
//        $this->authorize('updateProduct',Product::class);
        return $this->repo->update($request);
    }


    public function show(Product $product)
    {
        return $this->repo->show($product);
    }

    public function destroy(Product $product)
    {
        $user = auth('sanctum')->user();
//        $this->authorize('softDeleteProduct', $product);
        return $this->repo->destroy($product);
    }

    public function search(productFormRequest $request)
    {
        return $this->repo->search($request);
    }

    public function notFound()
    {
        return $this->ApiResponse(404, null, 'THIS PRODUCT NOT EXIST.');
    }
}
