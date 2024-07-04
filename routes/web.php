<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BankAccountController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/', [TransactionController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('transaction')->group(function () {
        Route::get('/view/{type}', [TransactionController::class, 'index'])->name('transaction.index');
        Route::get('/hidden', [TransactionController::class, 'dashboardValueHidden'])->name('transaction.hidden');
        Route::get('/edit/{id}', [TransactionController::class, 'edit'])->name('transaction.edit');
        Route::post('/update', [TransactionController::class, 'update'])->name('transaction.update');
        Route::get('/new', [TransactionController::class, 'new'])->name('transaction.new');
        Route::post('/save', [TransactionController::class, 'save'])->name('transaction.save');
        Route::get('/delete/{id}', [TransactionController::class, 'delete'])->name('transaction.delete');
    });


    Route::prefix('bank-account')->group(function () {
        Route::get('/', [BankAccountController::class, 'index'])->name('banck_account.index');
        Route::get('/transactions/{id}', [BankAccountController::class, 'transactions'])->name('banck_account.transactions');
        Route::get('/edit/{id}', [BankAccountController::class, 'edit'])->name('banck_account.edit');
        Route::post('/update', [BankAccountController::class, 'update'])->name('banck_account.update');
        Route::get('/new', [BankAccountController::class, 'new'])->name('banck_account.new');
        Route::post('/save', [BankAccountController::class, 'save'])->name('banck_account.save');
        Route::get('/delete/{id}', [BankAccountController::class, 'delete'])->name('banck_account.delete');
    });
});

require __DIR__.'/auth.php';
