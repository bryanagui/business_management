<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DarkModeController;
use App\Http\Controllers\ColorSchemeController;
use App\Http\Controllers\DataTablesController;
use App\Http\Controllers\Functions\ChangePictureController;
use App\Http\Controllers\Functions\StaffController;
use App\Http\Controllers\Functions\RoomManagementController;

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

Route::get('dark-mode-switcher', [DarkModeController::class, 'switch'])->name('dark-mode-switcher');
Route::get('color-scheme-switcher/{color_scheme}', [ColorSchemeController::class, 'switch'])->name('color-scheme-switcher');

Route::middleware('loggedin')->group(function () {
    Route::get('login', [AuthController::class, 'loginView'])->name('login.index');
    Route::post('login', [AuthController::class, 'login'])->name('login.check');
    Route::get('register', [AuthController::class, 'registerView'])->name('register.index');
    Route::post('register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    // BEGIN: DataTables
    Route::group(['prefix' => 'datatables'], function () {
        Route::get('/staff', [DataTablesController::class, 'staff'])->name('datatables.staff');
        Route::get('/rooms', [DataTablesController::class, 'rooms'])->name('datatables.rooms');
    });
    // END: DataTables

    // BEGIN: Change Picture Resource Requests
    Route::group(['prefix' => 'image'], function () {
        Route::post('store', [ChangePictureController::class, 'store'])->name('image.store'); // CREATE
        Route::post('show', [ChangePictureController::class, 'show'])->name('image.show'); // READ
        Route::post('update', [ChangePictureController::class, 'update'])->name('image.update'); // UPDATE
        Route::post('destroy', [ChangePictureController::class, 'destroy'])->name('image.destroy'); // DELETE
    });
    // END: Change Picture Resource Requests

    // BEGIN: GET Requests
    Route::get('/', [PageController::class, 'dashboard'])->name('dashboard');
    Route::get('reservations', [PageController::class, 'reservations'])->name('reservations');
    Route::get('rooms', [PageController::class, 'rooms'])->name('rooms');
    Route::get('guests', [PageController::class, 'guests'])->name('guests');
    Route::get('point-of-sale', [PageController::class, 'pointOfSale'])->name('pos');


    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    // END: GET Requests

    Route::middleware('role:Administrator|Twice|Hotel Owner|Manager|Executive')->group(function () {
        // Route: Staff //
        Route::get('staff', [PageController::class, 'staff'])->name('staff');
        // BEGIN: Staff Resource Requests
        Route::group(['prefix' => 'staff'], function () {
            Route::post('store', [StaffController::class, 'store'])->name('staff.store'); // CREATE
            Route::post('edit/{id}', [StaffController::class, 'edit'])->name('staff.edit'); // READ
            Route::post('show/{id}', [StaffController::class, 'show'])->name('staff.show'); // READ
            Route::patch('update/{id}', [StaffController::class, 'update'])->name('staff.update'); // UPDATE
            Route::delete('destroy/{id}', [StaffController::class, 'destroy'])->name('staff.destroy'); // DELETE
            Route::patch('restore/{id}', [StaffController::class, 'restore'])->name('staff.restore'); // DELETE (Restore)
        });
        // END: Staff Resource Requests

        // --------------------------------------------------------------------------------------------- //

        // Route: Room Management //
        Route::get('room-management', [PageController::class, 'roomManagement'])->name('room-management');
        // BEGIN: Room Management Resource Requests
        Route::group(['prefix' => 'room-management'], function () {
            Route::post('store', [RoomManagementController::class, 'store'])->name('room_management.store'); // CREATE
        });
        // END: Room Management Resource Requests

    });
});
