<?php
namespace modules\Products\Interfaces;


use Illuminate\Http\Request;
use modules\Products\Requests\ProductRequest;
use modules\Products\Models\Product;

interface ProductInterface {


    public function index($request);

    public function store(Request $request);

    public function update($request);

    public function show(Product $product);

    public function destroy(Product $product);

}
