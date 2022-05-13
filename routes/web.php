<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DarkModeController;
use App\Http\Controllers\ColorSchemeController;
use App\Http\Controllers\DataTablesController;
use App\Http\Controllers\Functions\ChangePictureController;
use App\Http\Controllers\Functions\ChangeProductImageController;
use App\Http\Controllers\Functions\ChangeThumbnailController;
use App\Http\Controllers\Functions\InventoryController;
use App\Http\Controllers\Functions\PointOfSaleController;
use App\Http\Controllers\Functions\StaffController;
use App\Http\Controllers\Functions\RoomManagementController;
use App\Http\Controllers\Functions\SwitchCategoryController;
use App\Http\Controllers\Functions\TransactionController;

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
        Route::get('/products', [DataTablesController::class, 'products'])->name('datatables.products');
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
    Route::get('invoice', [PageController::class, 'invoice'])->name('invoice');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    // END: GET Requests

    // --------------------------------------------------------------------------------------------- //

    Route::group(['prefix' => 'transactions'], function () {
        Route::get('/', [PageController::class, 'transactions'])->name('transactions');
        // BEGIN: POS Resource Requests
        Route::post('store', [PointOfSaleController::class, 'store'])->name('transactions.store'); // CREATE
        Route::post('edit/{id}', [PointOfSaleController::class, 'edit'])->name('transactions.edit'); // READ
        Route::post('show/{id}', [PointOfSaleController::class, 'show'])->name('transactions.show'); // READ
        Route::patch('update/{id}', [PointOfSaleController::class, 'update'])->name('transactions.update'); // UPDATE
        Route::delete('destroy', [PointOfSaleController::class, 'destroy'])->name('transactions.destroy'); // DELETE
        Route::patch('restore/{id}', [PointOfSaleController::class, 'restore'])->name('transactions.restore'); // DELETE (Restore)
        Route::get('create', [PointOfSaleController::class, 'create'])->name('transactions.create');
        // END: POS Resource Requests
    });

    Route::group(['prefix' => 'point-of-sale'], function () {
        Route::get('/', [PageController::class, 'pointOfSale'])->name('pos');
        // BEGIN: POS Resource Requests
        Route::post('store', [PointOfSaleController::class, 'store'])->name('pos.store'); // CREATE
        Route::post('edit/{id}', [PointOfSaleController::class, 'edit'])->name('pos.edit'); // READ
        Route::post('show/{id}', [PointOfSaleController::class, 'show'])->name('pos.show'); // READ
        Route::patch('update/{id}', [PointOfSaleController::class, 'update'])->name('pos.update'); // UPDATE
        Route::delete('destroy', [PointOfSaleController::class, 'destroy'])->name('pos.destroy'); // DELETE
        Route::patch('restore/{id}', [PointOfSaleController::class, 'restore'])->name('pos.restore'); // DELETE (Restore)
        Route::get('create', [PointOfSaleController::class, 'create'])->name('pos.create');

        Route::post('set-payment', [PointOfSaleController::class, 'setPayment'])->name('pos.set_payment');
        Route::post('switch', [SwitchCategoryController::class, 'switch'])->name('pos.switch');
        // END: POS Resource Requests
    });


    Route::middleware('role:Administrator|Twice|Hotel Owner|Manager|Executive')->group(function () {
        // Route: Transactions //
        // BEGIN: Transactions Resource Requests
        Route::group(['prefix' => 'transaction'], function () {
            Route::post('store', [TransactionController::class, 'store'])->name('transaction.store'); // CREATE
            Route::post('edit/{id}', [TransactionController::class, 'edit'])->name('transaction.edit'); // READ
            Route::post('show/{id}', [TransactionController::class, 'show'])->name('transaction.show'); // READ
            Route::patch('update/{id}', [TransactionController::class, 'update'])->name('transaction.update'); // UPDATE
            Route::delete('destroy', [TransactionController::class, 'destroy'])->name('transaction.destroy'); // DELETE
            Route::patch('restore/{id}', [TransactionController::class, 'restore'])->name('transaction.restore'); // DELETE (Restore)
        });
        // END: Transactions Resource Requests

        // Route: Staff //
        // BEGIN: Staff Resource Requests
        Route::group(['prefix' => 'staff'], function () {
            Route::get('/', [PageController::class, 'staff'])->name('staff');
            Route::post('store', [StaffController::class, 'store'])->name('staff.store'); // CREATE
            Route::post('edit/{id}', [StaffController::class, 'edit'])->name('staff.edit'); // READ
            Route::post('show/{id}', [StaffController::class, 'show'])->name('staff.show'); // READ
            Route::patch('update/{id}', [StaffController::class, 'update'])->name('staff.update'); // UPDATE
            Route::delete('destroy/{id}', [StaffController::class, 'destroy'])->name('staff.destroy'); // DELETE
            Route::patch('restore/{id}', [StaffController::class, 'restore'])->name('staff.restore'); // DELETE (Restore)
        });
        // END: Staff Resource Requests

        // --------------------------------------------------------------------------------------------- //

        // BEGIN: Inventory Resource Requests
        Route::group(['prefix' => 'inventory'], function () {
            Route::get('/', [PageController::class, 'inventory'])->name('inventory');
            Route::post('store', [InventoryController::class, 'store'])->name('inventory.store'); // CREATE
            Route::post('edit/{id}', [InventoryController::class, 'edit'])->name('inventory.edit'); // READ
            Route::patch('update/{id}', [InventoryController::class, 'update'])->name('inventory.update'); // UPDATE
            Route::delete('archive/{id}', [InventoryController::class, 'archive'])->name('inventory.archive'); // DELETE (Archive)
            Route::delete('destroy/{id}', [InventoryController::class, 'destroy'])->name('inventory.destroy'); // DELETE (Force Delete)
            Route::patch('restore/{id}', [InventoryController::class, 'restore'])->name('inventory.restore'); // DELETE (Restore)
        });
        // END: Inventory Resource Requests

        // --------------------------------------------------------------------------------------------- //

        // BEGIN: Change Thumbnail Resource Requests
        Route::group(['prefix' => 'thumbnail'], function () {
            Route::post('store', [ChangeThumbnailController::class, 'store'])->name('thumbnail.store'); // CREATE
            Route::post('show', [ChangeThumbnailController::class, 'show'])->name('thumbnail.show'); // READ
            Route::post('update', [ChangeThumbnailController::class, 'update'])->name('thumbnail.update'); // UPDATE
            Route::post('destroy', [ChangeThumbnailController::class, 'destroy'])->name('thumbnail.destroy'); // CREATE
        });
        // END: Change Thumbnail Resource Requests

        // BEGIN: Change Product Image Resource Requests
        Route::group(['prefix' => 'products'], function () {
            Route::post('store', [ChangeProductImageController::class, 'store'])->name('products.store'); // CREATE
            Route::post('show', [ChangeProductImageController::class, 'show'])->name('products.show'); // READ
            Route::post('update', [ChangeProductImageController::class, 'update'])->name('products.update'); // UPDATE
            Route::post('destroy', [ChangeProductImageController::class, 'destroy'])->name('products.destroy'); // CREATE
        });
        // END: Change Product Image Resource Requests

    });
});
