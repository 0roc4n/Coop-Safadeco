<?php

use App\Http\Controllers\Admin\SystemAccount\SystemAccountsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Middleware\AdminMiddleware;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::middleware(['auth:sanctum', AdminMiddleware::class])->group(function () {
    Route::get('/user/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');


    Route::get('/admin/systemaccounts', [SystemAccountsController::class, 'index'])->name('admin.system-account.index');
    Route::post('/admin/system-accounts/create', [SystemAccountsController::class, 'create'])->name('admin.system-account.create');
});