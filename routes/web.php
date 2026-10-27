<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Storefront & Menu Search/Filter
Route::get('/', [MenuController::class, 'index'])->name('home');

// Authentication (Multi-role + Google OAuth Login)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');

// Customer Orders & Payment Callbacks (Midtrans / Xendit)
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/{orderNumber}', [OrderController::class, 'show'])->name('orders.show');
Route::post('/orders/{orderNumber}/pay', [OrderController::class, 'confirmPayment'])->name('orders.pay');

// Kitchen Staff & Admin Display System
Route::middleware(['auth', 'role:admin,kitchen_staff'])->prefix('kitchen')->name('kitchen.')->group(function () {
    Route::get('/', [OrderController::class, 'kitchenIndex'])->name('index');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
});

// Admin Dashboard, Menu CRUD, Category CRUD, Ingredient Stock Management
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Menu CRUD
    Route::get('/menus', [MenuController::class, 'adminIndex'])->name('menus.index');
    Route::post('/menus', [MenuController::class, 'store'])->name('menus.store');
    Route::put('/menus/{menu}', [MenuController::class, 'update'])->name('menus.update');
    Route::delete('/menus/{menu}', [MenuController::class, 'destroy'])->name('menus.destroy');

    // Category CRUD
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Ingredient Stock Management
    Route::get('/ingredients', [IngredientController::class, 'index'])->name('ingredients.index');
    Route::post('/ingredients', [IngredientController::class, 'store'])->name('ingredients.store');
    Route::put('/ingredients/{ingredient}', [IngredientController::class, 'update'])->name('ingredients.update');
    Route::delete('/ingredients/{ingredient}', [IngredientController::class, 'destroy'])->name('ingredients.destroy');
});
