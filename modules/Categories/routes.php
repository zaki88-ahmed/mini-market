<?php
use Illuminate\Support\Facades\Route;
use modules\Categories\Controllers\CategoryController;

Route::middleware('auth:sanctum')->group(function () {

    Route::group(['prefix'=>'categories'],function () {
        Route::get('all',  [CategoryController::class, 'index'])->name('all-categories');
        Route::post('create',  [CategoryController::class, 'create'])->name('create-category');
        Route::post('update/{cat_id}',  [CategoryController::class, 'update'])->name('update-category');
        Route::post('delete/{cat_id}',  [CategoryController::class, 'delete'])->name('delete-category'); 
    });

});



// ->missing(function(){  return response("Category Id Not Exists", 404);});