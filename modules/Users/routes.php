<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use modules\Users\Controllers\UserController;


/********************* Authentication Routes *********************/
Route::post('users/register', [UserController::class, 'register']);
Route::post('users/login', [UserController::class, 'login']);
Route::post('users/logout',  [UserController::class, 'logout']);
Route::post('users/update-password',  [UserController::class, 'updatePassword']);

Route::get('/users', [UserController::class, 'getAllUsers']);

Route::get('users/show',  [UserController::class, 'showUserById']);

//Auth::routes(['verify' => true]);


