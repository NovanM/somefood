<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes (Laravel Sanctum / JWT Token Authentication & Webhooks)
|--------------------------------------------------------------------------
*/

// Public Auth API (JWT/Sanctum Token Issuance)
Route::post('/auth/login', [AuthController::class, 'apiLogin']);

// Public Menu Search & Filter API
Route::get('/menus', [MenuController::class, 'index']);

// Payment Webhooks (Midtrans & Xendit)
Route::post('/webhooks/payment/{orderNumber}', [OrderController::class, 'confirmPayment']);

// Protected Multi-Role API Endpoints
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', function (Request $request) {
        return response()->json([
            'success' => true,
            'user' => $request->user(),
        ]);
    });
});
