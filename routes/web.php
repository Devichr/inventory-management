<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StockController;
use App\Http\Middleware\PurchaseOfficer;
use App\Http\Middleware\WarehouseAdmin;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('process.login');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware([WarehouseAdmin::class])->group(function () {
        Route::get('/stock', [StockController::class, 'index'])->name('admin.stock');
        Route::get('/add-stock', [StockController::class, 'showAddStockForm'])->name('admin.add-stock');
        Route::get('/edit-stock/${id}', [StockController::class, 'editStock'])->name('admin.edit-stock');
        Route::post('/add-stock', [StockController::class, 'storeStock'])->name('admin.stock.store');
        Route::post('/edit-stock/${id}', [StockController::class, 'updateStock'])->name('admin.stock.update');
        Route::get('/admin/orders', [OrderController::class, 'index'])->name('orders.admin');
        Route::get('/admin/orders/create', [UserController::class, 'createOrder'])->name('orders.admin.new');
        Route::post('/admin/orders/create', [UserController::class, 'storeOrder'])->name('orders.admin.store');
    });
    Route::middleware([PurchaseOfficer::class])->group(function () {
        Route::get('/viewstock', [StockController::class, 'stock'])->name('viewStock');
        Route::get('/orders', [OrderController::class, 'order'])->name('orders.index');
        Route::get('/orders/{order}/eoq', [OrderController::class, 'showEOQForm'])->name('orders.eoq');
        Route::post('/orders/{order}/eoq', [OrderController::class, 'calculateEOQ'])->name('orders.eoq.calculate');
    });
});
