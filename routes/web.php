<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EOQCalculationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\FabricUsageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FabricController;
use App\Http\Controllers\StockController;
use App\Http\Middleware\PurchaseOfficer;
use App\Http\Middleware\WarehouseAdmin;
use App\Http\Controllers\ReportController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\PredictionController;


Route::get('predictions/generate', [PredictionController::class, 'generatePredictions'])->name('predictions.generate');


Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('process.login');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::patch('/notifications/{id}/read', [DashboardController::class, 'markAsRead'])->name('notifications.read');
    Route::resource('fabrics', FabricController::class);
    Route::resource('stocks', StockController::class);


    Route::middleware([WarehouseAdmin::class])->group(function () {
        Route::resource('fabric_usage', FabricUsageController::class);
        Route::resource('orders', OrderController::class);
        Route::get('/admin/orders', [OrderController::class, 'index'])->name('orders.admin');
        Route::get('/admin/orders/create', [UserController::class, 'createOrder'])->name('orders.admin.new');
        Route::post('/admin/orders/create', [UserController::class, 'storeOrder'])->name('orders.admin.store');
        Route::get('/usage',[StockController::class, 'usage'])->name('usage');
        Route::post('/usage',[StockController::class, 'storeUsage'])->name('usage.store');
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');


    });
    Route::middleware([PurchaseOfficer::class])->group(function () {
        Route::get('/eoq', [EOQCalculationController::class, 'create'])->name('eoq.index');
        Route::post('/eoq', [EOQCalculationController::class, 'store'])->name('eoq.store');
    });
});
