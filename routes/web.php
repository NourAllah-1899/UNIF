<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\BlogController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Main Dashboard
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Transactions
    Route::get('/transactions', function () {
        return Inertia::render('Transactions');
    })->name('transactions.index');

    // Card Center
    Route::get('/card-center', function () {
        return Inertia::render('CardCenter');
    })->name('card-center.index');

    // Wallet
    Route::get('/wallet', function () {
        return Inertia::render('Wallet');
    })->name('wallet.index');

    // Profile Routes (from default Laravel Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Blogs Resource
    Route::resource('blogs', BlogController::class);
});Route::post('blogs/{id}/restore', [BlogController::class, 'restore'])->name('blogs.restore');
Route::delete('blogs/{id}/force-delete', [BlogController::class, 'forceDelete'])->name('blogs.force-delete');
Route::middleware('auth')->group(function () {

    Route::resource('categories', CategoryController::class);
    Route::resource('transactions', TransactionsController::class);
});
Route::middleware(['auth', 'verified'])->group(function () {
    // Transactions routes
    Route::resource('transactions', TransactionsController::class)->except(['show']);

    // Additional transaction routes

    Route::post('transactions/{id}/restore', [TransactionsController::class, 'restore'])
        ->name('transactions.restore');
    Route::delete('transactions/{id}/force-delete', [TransactionsController::class, 'forceDelete'])
        ->name('transactions.force-delete');

    // Categories routes
    Route::resource('categories', CategoryController::class)->except(['show']);
});
require __DIR__.'/auth.php';
