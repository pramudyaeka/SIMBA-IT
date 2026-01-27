<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\AuthMiddleware;

/*
|--------------------------------------------------------------------------
| DEFAULT
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    return view('welcome'); // <-- PANGGIL welcome.blade.php
})->name('login');

Route::post('/login', function () {
    // sementara (dummy auth)
    return redirect()->route('dashboard');
})->name('login.process');

// Route::get('/signup', function () {
//     return view('auth.signup');
// })->name('signup');

Route::get('/register', function () {
    // Pastikan 'auth.signup' sesuai dengan nama file dan folder view kamu.
    // Misal: resources/views/auth/signup.blade.php
    return view('auth.signup'); 
})->name('register.form');

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('admin.dashboard-admin');
})->middleware(AuthMiddleware::class)->name('dashboard');

Route::get('/items', function () {
    return view('admin.crud.item.itemsManage');
})->name('items.manage');

Route::get('/manage/crud/add-item', function () {
    return view('admin.crud.item.addItem');
})->name('crud.addItem');

Route::get('/manage/crud/add-category', function () {
    return view('admin.crud.category.addCategory');
})->name('crud.addCategory');

Route::get('/categories', function () {
    return view('admin.crud.category.categoriesManage');
})->name('categories.manage');

Route::get('/reports', function () {
    return view('admin.reports');
})->name('reports.page');

Route::get('/history', function () {
    return view('admin.history');
})->name('history.page');

Route::get('/accountManagement', function () {
    return view('admin.accountManagement');
})->name('accountManagement.page');

Route::post('/register', [RegisterController::class, 'store']);

Route::post('/login', [LoginController::class, 'authenticate'])->name('login.process');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');