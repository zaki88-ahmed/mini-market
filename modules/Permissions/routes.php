<?php

use Illuminate\Support\Facades\Route;
use modules\Permissions\Controllers\PermissionController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('permissions', [PermissionController::class, 'index'])->name('permissions');
    Route::post('permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::put('permissions/{id}/edit', [PermissionController::class, 'update'])->name('permissions.edit');
    Route::delete('permissions/{id}/delete', [PermissionController::class, 'delete'])->name('permissions.delete');    
});



