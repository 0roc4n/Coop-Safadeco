<?php

use App\Http\Controllers\Admin\Books\BooksController;
use App\Http\Controllers\Admin\SystemAccount\SystemAccountsController;
use App\Http\Controllers\Admin\SystemPrevilage\SystemPrevilageController;
use App\Http\Controllers\Admin\Clientele\ClienteleController;
use App\Http\Controllers\Admin\Billing\BillStateHDRController;
use App\Http\Controllers\Admin\AccountCodes\AccountCodesController;
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
    
    // Clientele Management
    Route::get('/admin/clientele', [ClienteleController::class, 'index'])->name('admin.clientele.index');
    Route::post('/admin/clientele', [ClienteleController::class, 'store'])->name('admin.clientele.store');
    Route::put('/admin/clientele/{clientCode}', [ClienteleController::class, 'update'])->name('admin.clientele.update');
    Route::delete('/admin/clientele/{clientCode}', [ClienteleController::class, 'destroy'])->name('admin.clientele.destroy');

    // Financials & Transactions
    Route::get('/admin/book-journals', [BooksController::class, 'index'])->name('admin.book-journals.index');
    Route::post('/admin/book-journals', [BooksController::class, 'store'])->name('admin.book-journals.store');
    Route::put('/admin/book-journals/{id}', [BooksController::class, 'update'])->name('admin.book-journals.update');
    Route::delete('/admin/book-journals/{id}', [BooksController::class, 'destroy'])->name('admin.book-journals.destroy');
    
    // Billing Statements HDR
    Route::get('/admin/billing/statements-hdr', [BillStateHDRController::class, 'index'])->name('billing.statements.index');
    Route::post('/admin/billing/statements', [BillStateHDRController::class, 'store'])->name('billing.statements.store');
    Route::get('/admin/billing/statements/{id}', [BillStateHDRController::class, 'show'])->name('billing.statements.show');
    Route::put('/admin/billing/statements/{id}', [BillStateHDRController::class, 'update'])->name('billing.statements.update');
    Route::delete('/admin/billing/statements/{id}', [BillStateHDRController::class, 'destroy'])->name('billing.statements.destroy');
    
    // Account Codes
    Route::get('/admin/account-codes', [AccountCodesController::class, 'index'])->name('admin.account-codes.index');
    Route::post('/admin/account-codes', [AccountCodesController::class, 'store'])->name('admin.account-codes.store');
    Route::get('/admin/account-codes/{acctCode}', [AccountCodesController::class, 'show'])->name('admin.account-codes.show');
    Route::put('/admin/account-codes/{acctCode}', [AccountCodesController::class, 'update'])->name('admin.account-codes.update');
    Route::delete('/admin/account-codes/{acctCode}', [AccountCodesController::class, 'destroy'])->name('admin.account-codes.destroy');
});