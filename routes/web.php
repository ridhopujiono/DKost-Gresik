<?php

use App\Http\Controllers\GuestWaitingListController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\RoomMediaController;
use App\Models\LatePaymentNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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
})->name('login');
Route::get('/logout', function () {
    Session::flush();
    Auth::logout();
    return redirect('/')->with('success', 'Anda berhasil keluar. Terimakasih');
});

Route::middleware(['is_admin'])->group(function () {
    Route::resource('locations', LocationController::class)->middleware('is_admin');
    Route::resource('rooms', RoomController::class)->middleware('is_admin');
    Route::resource('room/media', RoomMediaController::class)->middleware('is_admin');
    Route::resource('residents', ResidentController::class)->middleware('is_admin');
    Route::resource('facilities', FacilityController::class)->middleware('is_admin');
    Route::resource('payments', PaymentController::class)->middleware('is_admin');
    Route::resource('payment/lates', LatePaymentNotification::class)->middleware('is_admin');
    Route::resource('guests', GuestWaitingListController::class)->middleware('is_admin');
});
