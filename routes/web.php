<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;

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
    | AKSES UMUM (ADMIN & STAFF) - READ ONLY
    |--------------------------------------------------------------------------
    */
    
    // Dashboard
    Route::get('/dashboard', [ItemsController::class, 'dashboard'])->name('dashboard');

    // Lihat Daftar Item & Kategori
    Route::get('/items', [ItemsController::class, 'index'])->name('items.manage');
    Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.manage');

    // History Log (Filter Staff/Admin diatur di dalam HistoryController)
    Route::get('/history', [HistoryController::class, 'index'])->name('history.page');


    /*
    |--------------------------------------------------------------------------
    | AKSES KHUSUS ADMIN (DILINDUNGI MIDDLEWARE 'admin')
    |--------------------------------------------------------------------------
    */
    Route::middleware('admin')->group(function () {

        // --- ITEM MANAGEMENT (ACTIONS) ---
        Route::post('/items', [ItemsController::class, 'store'])->name('items.store');
        Route::put('/items/{id}', [ItemsController::class, 'update'])->name('items.update');
        Route::delete('/items/{id}', [ItemsController::class, 'destroy'])->name('items.destroy');
        Route::post('/items/transaction', [ItemsController::class, 'processTransaction'])->name('items.transaction');

        // --- CATEGORY MANAGEMENT (ACTIONS) ---
        Route::post('/categories', [CategoriesController::class, 'store'])->name('categories.store');

        // --- REPORTS & EXPORT ---
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.page');
        Route::get('/export-excel', [ReportController::class, 'exportExcel'])->name('reports.excel');
        Route::get('/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.pdf');

        // --- ACCOUNT MANAGEMENT (USER CRUD) ---
        Route::get('/account-management', [UserController::class, 'index'])->name('accountManagement.page');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
        
    });

});