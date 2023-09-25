<?php

use App\Http\Controllers\GuestWaitingListController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\RoomMediaController;
use App\Mail\SendExampleMail;
use App\Models\LatePaymentNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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
Route::get('/email', function () {
    return view('email.accept_room_reservation');
});

Route::middleware(['is_admin'])->group(function () {
    Route::resource('locations', LocationController::class);
    Route::resource('rooms', RoomController::class);
    Route::resource('room/media', RoomMediaController::class);
    Route::resource('residents', ResidentController::class);
    Route::resource('facilities', FacilityController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('payment/lates', LatePaymentNotification::class);
    Route::resource('guests', GuestWaitingListController::class);
});
