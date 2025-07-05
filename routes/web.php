<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Public Routes
Route::get('/', function () {
    return view('welcome');
});
Route::get('/foods', [FoodController::class, 'index'])->name('foods.index');
Route::post('/foods/{id}/order-now', [FoodController::class, 'orderNow'])->name('foods.orderNow');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// User Routes (Protected)
Route::middleware(['user'])->group(function () {
    Route::get('/user/dashboard', [AuthController::class, 'userDashboard'])->name('user.dashboard');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::put('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');
    Route::post('/orders/{id}/upload-bukti', [OrderController::class, 'uploadBuktiTransfer'])->name('orders.uploadBukti');
});

// Admin Routes (Protected)
Route::middleware(['admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/admin/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::post('/admin/orders/{order}/confirm-cash', [AdminController::class, 'confirmPaymentCash'])->name('admin.orders.confirmCash');
    Route::post('/admin/orders/{id}/confirm-payment', [OrderController::class, 'confirmPayment'])->name('admin.orders.confirmPayment');
});

// Kurir Routes (Protected)
Route::middleware(['kurir'])->group(function () {
    Route::get('/kurir/dashboard', [OrderController::class, 'dashboardKurir'])->name('kurir.dashboard');
    Route::post('/kurir/orders/{order}/update', [OrderController::class, 'updateStatusKurir'])->name('kurir.order.update');
});
