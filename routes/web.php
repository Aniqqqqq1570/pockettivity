<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;

Route::get('/', function () {
    return view('home');
})->name('home');


Route::get('/tentang', function () {
    return view('about');
})->name('about');


Route::get('/fitur', function () {
    return view('features');
})->name('features');


Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.store');


Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');


Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');


    Route::get('/transactions', function () {
        return view('transactions');
    })->name('transactions');
    

    Route::post('/transactions', [TransactionController::class, 'store'])
    ->name('transactions.store');


    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

});