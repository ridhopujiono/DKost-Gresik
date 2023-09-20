<?php

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
