<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController; // <-- DITAMBAHKAN: Import ReportController

/*
|--------------------------------------------------------------------------
| DEFAULT ROUTE
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (GUEST ONLY)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    // Login
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.process');

    // Register
    Route::get('/register', [RegisterController::class, 'index'])->name('register.form');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (AUTH REQUIRED)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [ItemsController::class, 'dashboard'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | ITEM MANAGEMENT (CRUD & SCANNER)
    |--------------------------------------------------------------------------
    */
    Route::get('/items', [ItemsController::class, 'index'])->name('items.manage');
    Route::post('/items', [ItemsController::class, 'store'])->name('items.store');
    Route::put('/items/{id}', [ItemsController::class, 'update'])->name('items.update');
    Route::delete('/items/{id}', [ItemsController::class, 'destroy'])->name('items.destroy');
    
    // Rute untuk memproses hasil scan QR
    Route::post('/items/transaction', [ItemsController::class, 'processTransaction'])->name('items.transaction');

    /*
    |--------------------------------------------------------------------------
    | CATEGORY MANAGEMENT (CRUD)
    |--------------------------------------------------------------------------
    */
    Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.manage');
    Route::post('/categories', [CategoriesController::class, 'store'])->name('categories.store');

    /*
    |--------------------------------------------------------------------------
    | HISTORY & REPORTS
    |--------------------------------------------------------------------------
    */
    Route::get('/history', [HistoryController::class, 'index'])->name('history.page');

    // <-- DIPERBAIKI: Mengarah ke ReportController dan namanya diubah menjadi reports.index
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.page');

    /*
    |--------------------------------------------------------------------------
    | ACCOUNT MANAGEMENT (USER CRUD)
    |--------------------------------------------------------------------------
    */
    Route::get('/account-management', [UserController::class, 'index'])->name('accountManagement.page');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

});