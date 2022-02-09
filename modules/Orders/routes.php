<?php

use Illuminate\Support\Facades\Route;
use modules\Orders\Controllers\OrderController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('orders',  [OrderController::class, 'allOrders'])->middleware('EmailVerify');
    Route::post('orders/create',  [OrderController::class, 'createOrder']);
    Route::get('orders/show',  [OrderController::class, 'orderDetails']);
    Route::post('orders/edit',  [OrderController::class, 'updateOrder']);
    Route::post('orders/delete',  [OrderController::class, 'softDeleteOrder']);
    Route::post('orders/restore',  [OrderController::class, 'restoreOrder']);
    Route::post('cart/create',  [OrderController::class, 'setItemCart']);
    Route::get('cart/call',  [OrderController::class, 'getItemCart']);

});


