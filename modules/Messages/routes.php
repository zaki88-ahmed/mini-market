<?php
use Illuminate\Support\Facades\Route;
use modules\Categories\Controllers\CategoryController;
use modules\Messages\Controllers\MessageController;

Route::get('/messages/', [MessageController::class, 'index']);
Route::get('/messages/show/{message}', [MessageController::class, 'show']);
Route::post('/messages/response/{message}', [MessageController::class, 'response']);



