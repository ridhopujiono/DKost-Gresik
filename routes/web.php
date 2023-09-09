<?php

use App\Http\Controllers\GuestWaitingListController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomFacilityController;
use App\Models\LatePaymentNotification;
use Illuminate\Support\Facades\Route;

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
Route::resource('location', LocationController::class);
Route::resource('rooms/master', RoomController::class);
Route::resource('resident', ResidentController::class);
Route::resource('facility', RoomFacilityController::class);
Route::resource('payment', PaymentController::class);
Route::resource('payment/late', LatePaymentNotification::class);
Route::resource('waiting_list', GuestWaitingListController::class);
