<?php

namespace App\Http\Controllers\Admin\LoanProduct;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoanProductRequest;
use App\Models\LoanProduct;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class LoanProductController extends Controller
{
    /**
     * Display a listing of loan products
     */
    public function index(Request $request)
    {
        $query = LoanProduct::select([
            'LoanCode',
            'LoanType',
            'Description',
            'InterestRate',
            'LoanAmount',
            'MinLoanAmount',
            'MaxLoanAmount',
            'MinTerm',
            'MaxTerm',
            'HasCollateral',
            'HasCoMaker',
            'FixedRate',
            'created_at',
            'updated_at'
        ]);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('LoanCode', 'like', "%{$search}%")
                  ->orWhere('Description', 'like', "%{$search}%");
            });
        }

        // Filter by loan type
        if ($request->filled('loan_type') && $request->loan_type !== 'all') {
            $query->where('LoanType', $request->loan_type);
        }

        // Filter by collateral requirement
        if ($request->filled('has_collateral') && $request->has_collateral !== 'all') {
            $query->where('HasCollateral', $request->has_collateral);
        }

        // Sort
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $loanProducts = $query->paginate(15)->withQueryString();

        // Calculate statistics
        $totalProducts = LoanProduct::count();
        $activeProducts = LoanProduct::where('LoanAmount', '>', 0)->count();
        $collateralRequired = LoanProduct::where('HasCollateral', 1)->count();
        $averageInterestRate = LoanProduct::avg('InterestRate');

        $statistics = [
            'total_products' => $totalProducts,
            'active_products' => $activeProducts,
            'collateral_required' => $collateralRequired,
            'average_interest_rate' => round($averageInterestRate ?? 0, 2)
        ];

        return Inertia::render('Admin/LoanProduct/Index', [
            'loanProducts' => $loanProducts,
            'statistics' => $statistics,
            'filters' => $request->only(['search', 'loan_type', 'has_collateral']),
            'sort' => [
                'field' => $sortField,
                'direction' => $sortDirection
            ]
        ]);
    }

    /**
     * Show the form for creating a new loan product
     */
    public function create()
    {
        return Inertia::render('Admin/LoanProduct/Create');
    }

    /**
     * Store a newly created loan product
     */
    public function store(LoanProductRequest $request)
    {
        try {
            DB::beginTransaction();

            $loanProduct = LoanProduct::create($request->validated());

            DB::commit();

            return redirect()
                ->route('admin.loan-products.index')
                ->with('success', 'Loan product created successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create loan product: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified loan product
     */
    public function show(LoanProduct $loanProduct)
    {
        // Load related loan applications count
        $loanApplicationsCount = $loanProduct->loanApplications()->count();
        $approvedApplicationsCount = $loanProduct->loanApplications()->where('Approved', 1)->count();

        return Inertia::render('Admin/LoanProduct/Show', [
            'loanProduct' => $loanProduct,
            'loanApplicationsCount' => $loanApplicationsCount,
            'approvedApplicationsCount' => $approvedApplicationsCount
        ]);
    }

    /**
     * Show the form for editing the specified loan product
     */
    public function edit(LoanProduct $loanProduct)
    {
        return Inertia::render('Admin/LoanProduct/Edit', [
            'loanProduct' => $loanProduct
        ]);
    }

    /**
     * Update the specified loan product
     */
    public function update(LoanProductRequest $request, LoanProduct $loanProduct)
    {
        try {
            DB::beginTransaction();

            $loanProduct->update($request->validated());

            DB::commit();

            return redirect()
                ->route('admin.loan-products.index')
                ->with('success', 'Loan product updated successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update loan product: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified loan product
     */
    public function destroy(LoanProduct $loanProduct)
    {
        try {
            DB::beginTransaction();

            // Check if loan product is being used in applications
            $applicationsCount = $loanProduct->loanApplications()->count();
            if ($applicationsCount > 0) {
                return redirect()
                    ->back()
                    ->withErrors(['error' => "Cannot delete loan product. It is being used in {$applicationsCount} loan applications."]);
            }

            $loanProduct->delete();

            DB::commit();

            return redirect()
                ->route('admin.loan-products.index')
                ->with('success', 'Loan product deleted successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->withErrors(['error' => 'Failed to delete loan product: ' . $e->getMessage()]);
        }
    }
}
