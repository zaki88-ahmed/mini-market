<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use modules\Products\Controllers\ProductController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('products/create', [ProductController::class,'store'])->name('product.create');
//    Route::put('products/{product}', [ProductController::class, 'update'])->name('product.update')
//        ->missing(function (Request $request) {
//            return Redirect::route('product.notfound');
//        });
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('product.delete')
        ->missing(function (Request $request) {
            return Redirect::route('product.notfound');
        });

    Route::post('update/products', [ProductController::class, 'update']);
});

Route::get('notfound', [ProductController::class, 'notFound'])->name('product.notfound');
Route::post('search', [ProductController::class, 'search'])->name('product.search');
Route::get('products', [ProductController::class, 'index'])->name('product.all');
Route::get('products/{product}', [ProductController::class, 'show'])->name('product.category')
    ->missing(function (Request $request) {
        return Redirect::route('product.notfound');
    });

