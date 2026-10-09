<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminTransactionController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MonthlyStatementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

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

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/monthly-statement', [MonthlyStatementController::class, 'index'])
        ->name('monthly-statement');

    Route::get('/monthly-statement/print', [MonthlyStatementController::class, 'print'])
        ->name('monthly-statement.print');

    Route::get('/monthly-statement/pdf', [MonthlyStatementController::class, 'download'])
        ->name('monthly-statement.pdf');

    Route::get('/categories', [CategoryController::class, 'index'])
        ->name('categories');

    Route::post('/categories', [CategoryController::class, 'store'])
        ->name('categories.store');

    Route::put('/categories/{category}', [CategoryController::class, 'update'])
        ->name('categories.update');

    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])
        ->name('categories.destroy');

    Route::get('/budgets', [BudgetController::class, 'index'])->name('budgets');
    Route::post('/budgets', [BudgetController::class, 'store'])->name('budgets.store');
    Route::put('/budgets/{budget}', [BudgetController::class, 'update'])->name('budgets.update');
    Route::delete('/budgets/{budget}', [BudgetController::class, 'destroy'])->name('budgets.destroy');

    Route::get('/analysis', [AnalysisController::class, 'index'])->name('analysis');
    Route::post('/analysis/generate', [AnalysisController::class, 'generate'])
        ->middleware('throttle:5,1')
        ->name('analysis.generate');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::get('/admin/users', [AdminUserController::class, 'index'])
        ->middleware('admin')
        ->name('admin.users');

    Route::put('/admin/users/{user}/admin', [AdminUserController::class, 'makeAdmin'])
        ->middleware('admin')
        ->name('admin.users.makeAdmin');

    Route::put('/admin/users/{user}/user', [AdminUserController::class, 'makeUser'])
        ->middleware('admin')
        ->name('admin.users.makeUser');

    Route::get('/admin/dashboard', [AdminController::class, 'index'])
        ->middleware('admin')
        ->name('admin.dashboard');

    Route::get('/admin/transactions', [AdminTransactionController::class, 'index'])
        ->middleware('admin')
        ->name('admin.transactions');

    Route::get('/transactions', [TransactionController::class, 'index'])
        ->name('transactions');

    Route::post('/transactions', [TransactionController::class, 'store'])
        ->name('transactions.store');

    Route::get('/transactions/{transaction}/edit', [TransactionController::class, 'edit'])
        ->name('transactions.edit');

    Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])
        ->name('transactions.update');

    Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])
        ->name('transactions.destroy');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

});
