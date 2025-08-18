<?php

use App\Http\Controllers\Admin\SystemAccount\SystemAccountsController;
use App\Http\Controllers\Admin\SystemPrevilage\SystemPrevilageController;
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

// Admin routes
Route::middleware(['auth:sanctum', AdminMiddleware::class])->group(function () {
    Route::get('/user/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // System Administrator
    Route::get('/admin/systemaccounts', [SystemAccountsController::class, 'index'])->name('admin.system-account.index');
    Route::post('/admin/system-accounts/create', [SystemAccountsController::class, 'create'])->name('admin.system-account.create');
    // System Previlage
    Route::get('/admin/system-previlage', [SystemPrevilageController::class, 'index'])->name('admin.system-previlage.index');
    Route::post('/admin/system-privileges/update', [SystemPrevilageController::class, 'update'])->name('admin.system-privileges.update');
    Route::post('/admin/system-privileges/create', [SystemPrevilageController::class, 'create'])->name('admin.system-privileges.create');
});