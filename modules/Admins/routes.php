<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use modules\Admins\Controllers\AdminController;


Route::middleware('auth:sanctum')->group(function () {
    Route::post('create/admins', [AdminController::class, 'store'])->name('admins.create');
    Route::get('admins', [AdminController::class, 'index'])->name('admins.all');
    Route::post('admin/logout',  [AdminController::class, 'logout'])->name('admin.logout');
    Route::get('admins/{admin}', [AdminController::class, 'show'])->name('admins.admin')
        ->missing(function (Request $request) {
            return Redirect::route('admin.notfound');
        });
    Route::put('admins/{admin}', [AdminController::class, 'update'])->name('admins.update')
        ->missing(function (Request $request) {
            return Redirect::route('admin.notfound');
        });
    Route::delete('admins/{admin}', [AdminController::class, 'destroy'])->name('admins.delete')
        ->missing(function (Request $request) {
            return Redirect::route('admin.notfound');
        });
});

Route::post('/admin/login',  [AdminController::class, 'login'])->name('admin.login');
//Route::post('/admin/login',  function (){
//    return 'aa';
//})->name('admin.login');
Route::get('notfound', [AdminController::class, 'notFound'])->name('admin.notfound');
