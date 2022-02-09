<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use modules\Customers\Controllers\CustomerController;


//Route::get('customers',  [CustomerController::class, 'allCustomers']);
//Route::post('/test',  [AdminController::class, 'test']);
Route::middleware('auth:sanctum')->group(function () {

    Route::post('customers/update-password',  [CustomerController::class, 'updatePassword']);
    Route::get('customers',  [CustomerController::class, 'allCustomers']);
    Route::get('customers/show',  [CustomerController::class, 'customerDetails']);
    Route::post('customers/edit',  [CustomerController::class, 'updateCustomer']);
    Route::post('customers/delete',  [CustomerController::class, 'softDeleteCustomer']);
    Route::post('customers/restore',  [CustomerController::class, 'restoreCustomer']);
});

Route::post('customers/register',  [CustomerController::class, 'register']);
Route::post('customers/login',  [CustomerController::class, 'login']);
Route::post('customers/logout',  [CustomerController::class, 'logout']);


Route::get('customers/register/verify/{id}',  [CustomerController::class, 'verify'])->name('verify.mail');

//Auth::routes(['verify' => true]);




