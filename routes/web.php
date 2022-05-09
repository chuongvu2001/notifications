<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SmsController;
use Illuminate\Support\Arr;
use App\Http\Controllers\StudyController;

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

Route::get('/', function (\Illuminate\Http\Request $request) {
    return view('welcome');
});
Route::get('/send-database', [HomeController::class, 'sendNotificationDatabase']);
//Route::get('test-email', [\App\Http\Controllers\JobController::class,'processQueue']);

Route::get('/sms', [SmsController::class, 'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/active', [\App\Http\Controllers\Auth\LoginController::class, 'active'])->name('user.active');
Route::post('/save-active', [\App\Http\Controllers\Auth\LoginController::class, 'saveActive'])->name('user.save.active');

Route::get('/fcm',[\App\Http\Controllers\FcmController::class,'index']);
Route::get('/send-notification-fcm',[\App\Http\Controllers\FcmController::class,'sendNotification']);

Route::get('/store-queue',[StudyController::class,'storeQueue']);
