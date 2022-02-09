<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PayMobController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialLoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/redirect/{driver}',[SocialLoginController::class,'redirectToSocial'])->name('login.google');
//Route::get('/callback/{driver}',[SocialLoginController::class,'handleSocialCallback']);
//Auth::routes();
//
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('order-status/{order_id}/{status}',[HomeController::class, 'editOrderStatus'])->name('edit.status');


Route::get('/redirect/{driver}',[SocialLoginController::class,'redirectToSocial'])->name('login.social');
Route::get('/callback/{driver}',[SocialLoginController::class,'handleSocialCallback']);

Route::get('pay',[PayMobController::class,'index'])->name('payment');

Route::post('/save-push-notification-token', [HomeController::class, 'savePushNotificationToken'])->name('save-push-notification-token');
Route::get('/send-push-notification/{order_id}/{status}', [HomeController::class, 'sendPushNotification'])->name('send.push-notification');

