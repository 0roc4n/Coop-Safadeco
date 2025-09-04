<?php

namespace App\Http\Controllers\Admin\LoanApplication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LoanApplicationController extends Controller
{
    public function index(){
        return Inertia::render('Admin/LoanApplication/Index');
    }
}
