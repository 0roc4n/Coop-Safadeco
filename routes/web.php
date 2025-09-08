<?php

use App\Http\Controllers\Admin\Books\BooksController;
use App\Http\Controllers\Admin\SystemAccount\SystemAccountsController;
use App\Http\Controllers\Admin\SystemPrevilage\SystemPrevilageController;
use App\Http\Controllers\Admin\Clientele\ClienteleController;
use App\Http\Controllers\Admin\Billing\BillStateHDRController;
use App\Http\Controllers\Admin\AccountCodes\AccountCodesController;
use App\Http\Controllers\Admin\LoanApplication\LoanApplicationController;
use App\Http\Controllers\Admin\LoanProduct\LoanProductController;
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
    Route::get('/admin/clientele/{clientCode}', [ClienteleController::class, 'show'])->name('admin.clientele.show');
    Route::get('/admin/clientele/{clientCode}/export/{format}', [ClienteleController::class, 'export'])->name('admin.clientele.export');
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
    Route::get('/admin/account-codes/export/csv', [AccountCodesController::class, 'export'])->name('admin.account-codes.export');
    Route::post('/admin/account-codes/import/csv', [AccountCodesController::class, 'import'])->name('admin.account-codes.import');
    Route::get('/admin/account-codes/template/download', [AccountCodesController::class, 'downloadTemplate'])->name('admin.account-codes.template');

    // Loan Applications
    Route::get('/admin/loan-applications', [LoanApplicationController::class, 'index'])->name('admin.loan-applications.index');
    Route::get('/admin/loan-applications/create', [LoanApplicationController::class, 'create'])->name('admin.loan-applications.create');
    Route::post('/admin/loan-applications', [LoanApplicationController::class, 'store'])->name('admin.loan-applications.store');
    Route::get('/admin/loan-applications/{loanApplication}', [LoanApplicationController::class, 'show'])->name('admin.loan-applications.show');
    Route::get('/admin/loan-applications/{loanApplication}/edit', [LoanApplicationController::class, 'edit'])->name('admin.loan-applications.edit');
    Route::put('/admin/loan-applications/{loanApplication}', [LoanApplicationController::class, 'update'])->name('admin.loan-applications.update');
    Route::delete('/admin/loan-applications/{loanApplication}', [LoanApplicationController::class, 'destroy'])->name('admin.loan-applications.destroy');
    Route::patch('/admin/loan-applications/{loanApplication}/approval', [LoanApplicationController::class, 'updateApproval'])->name('admin.loan-applications.approval');
    Route::get('/admin/loan-applications/search-clients', [LoanApplicationController::class, 'searchClients'])->name('admin.loan-applications.search-clients');

    // Loan Products
    Route::get('/admin/loan-products', [LoanProductController::class, 'index'])->name('admin.loan-products.index');
    Route::get('/admin/loan-products/create', [LoanProductController::class, 'create'])->name('admin.loan-products.create');
    Route::post('/admin/loan-products', [LoanProductController::class, 'store'])->name('admin.loan-products.store');
    Route::get('/admin/loan-products/{loanProduct}', [LoanProductController::class, 'show'])->name('admin.loan-products.show');
    Route::get('/admin/loan-products/{loanProduct}/edit', [LoanProductController::class, 'edit'])->name('admin.loan-products.edit');
    Route::put('/admin/loan-products/{loanProduct}', [LoanProductController::class, 'update'])->name('admin.loan-products.update');
    Route::delete('/admin/loan-products/{loanProduct}', [LoanProductController::class, 'destroy'])->name('admin.loan-products.destroy');
});