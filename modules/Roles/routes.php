<?php

use Illuminate\Support\Facades\Route;
use modules\Roles\Controllers\RoleController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('roles', [RoleController::class, 'index'])->name('roles');
    Route::post('roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::put('roles/{id}/edit', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('roles/{id}/delete', [RoleController::class, 'delete'])->name('roles.delete');
    Route::post('roles/{id}/assign-permissions', [RoleController::class, 'assignPermission'])->name('roles.assign');
    
});
