<?php
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\GatewayController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'API funcionando';
});

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/transactions', [TransactionController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    
    Route::middleware('role:admin,manager')->group(function () {
        Route::apiResource('users', UserController::class);
    });

    Route::middleware('role:admin,manager,finance')->group(function () {
        Route::apiResource('products', ProductController::class);
    });

    Route::patch('/products/{id}/restore', [ProductController::class, 'restore']);

    Route::middleware('role:admin,finance')->group(function () {
        Route::post('/transactions/{id}/refund', [TransactionController::class, 'refund']);
        Route::get('/transactions', [TransactionController::class, 'index']);
        Route::get('/transactions/{id}', [TransactionController::class, 'show']);
    });

    Route::middleware('role:admin')->group(function () {
        Route::patch('/gateways/{id}/toggleactive', [GatewayController::class, 'toggleActive']);
        Route::patch('/gateways/{id}/priority', [GatewayController::class, 'changePriority']);
        Route::get('/clients', [ClientController::class, 'index']);
        Route::get('/clients/{id}', [ClientController::class, 'show']);
        Route::post('/clients', [ClientController::class, 'store']);
        Route::put('/clients/{id}', [ClientController::class, 'update']);
        Route::delete('/clients/{id}', [ClientController::class, 'destroy']);
    });
});