<?php

use App\Http\Controllers\api\LatePaymentNotificationController;
use App\Http\Controllers\api\ResidentController;
use App\Http\Controllers\api\RoomController;
use App\Http\Controllers\GuestWaitingListController;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('guest', [GuestWaitingListController::class, 'post_guest']);
Route::post('payment', [PaymentController::class, 'post_payment']);
Route::get('rooms', [RoomController::class, 'getAll']);
Route::get('rooms/{id}', [RoomController::class, 'getById']);
Route::post('rooms/reservation/{room_id}/{user_id}/{type}', [RoomController::class, 'reservation']);

Route::post('resident/user_id/{user_id}', [ResidentController::class, 'getResidentByUserId']);
Route::post('resident/resident_id/{resident_id}', [ResidentController::class, 'getResidentByResidentId']);

Route::get('resident/payment_histories/resident_id/{resident_id}', [ResidentController::class, 'getResidentPaymentHistoriesByResidentId']);
Route::post('resident/payment_histories/resident_id/{resident_id}', [ResidentController::class, 'postResidentPayment']);

Route::post('resident/profile/{resident_id}', [ResidentController::class, 'postResidentProfile']);

Route::post('notification/user_id/{user_id}', [LatePaymentNotificationController::class, 'getNotificationByUserId']);
