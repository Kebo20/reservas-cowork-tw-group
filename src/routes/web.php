<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middlewares\PermissionMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {

    Route::group(['middleware' => ['can:view-register-room']], function () {
        Route::get('/rooms/register', [RoomController::class, 'register'])->name('rooms.register');
    });

    Route::group(['middleware' => ['can:all-room']], function () {
        Route::resource('/rooms', RoomController::class);
    });


    Route::get('/bookings/register', [BookingController::class, 'register'])->name('bookings.register');
    Route::patch('/bookings/update_state', [BookingController::class, 'update_state'])->name('bookings.update_state');

    Route::resource('/bookings', BookingController::class);
});
