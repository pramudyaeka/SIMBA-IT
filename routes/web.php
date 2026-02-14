<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\HistoryController;

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

    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard-admin');
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | ITEM MANAGEMENT (CRUD)
    |--------------------------------------------------------------------------
    */
    Route::get('/items', [ItemsController::class, 'index'])->name('items.manage');
    Route::post('/items', [ItemsController::class, 'store'])->name('items.store');
    Route::put('/items/{id}', [ItemsController::class, 'update'])->name('items.update');
    Route::delete('/items/{id}', [ItemsController::class, 'destroy'])->name('items.destroy');

    /*
    |--------------------------------------------------------------------------
    | CATEGORY MANAGEMENT (CRUD)
    |--------------------------------------------------------------------------
    */
    Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.manage');
    Route::post('/categories', [CategoriesController::class, 'store'])->name('categories.store');

    /*
    |--------------------------------------------------------------------------
    | HISTORY
    |--------------------------------------------------------------------------
    */
    Route::get('/history', [HistoryController::class, 'index'])->name('history.page');


    // Rute untuk halaman Dashboard
    Route::get('/dashboard', [ItemsController::class, 'dashboard'])->name('dashboard');

    // Rute untuk memproses hasil scan QR
    Route::post('/items/transaction', [ItemsController::class, 'processTransaction'])->name('items.transaction');
    /*
    |--------------------------------------------------------------------------
    | OTHER PAGES
    |--------------------------------------------------------------------------
    */
    Route::get('/reports', function () {
        return view('admin.reports');
    })->name('reports.page');

    Route::get('/account-management', function () {
        return view('admin.accountManagement');
    })->name('accountManagement.page');
});
