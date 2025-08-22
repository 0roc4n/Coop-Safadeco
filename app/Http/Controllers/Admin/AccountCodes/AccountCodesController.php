<?php

namespace App\Http\Controllers\Admin\AccountCodes;

use App\Http\Controllers\Controller;
use App\Models\AcctCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class AccountCodesController extends Controller
{
    /**
     * Display a listing of the account codes.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $query = AcctCode::query()
            ->select('*')
            ->orderBy('AcctCode', 'asc');
        
        // Search functionality
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('AcctCode', 'like', "%{$search}%")
                  ->orWhere('Description', 'like', "%{$search}%");
            });
        }
        
        // Type filter
        if ($request->has('type') && $request->type !== '') {
            $query->where('Type', $request->type);
        }
        
        // Pagination
        $accountCodes = $query->paginate(10)->withQueryString();
        
        // Get unique types for filter dropdown
        $types = AcctCode::select('Type')
            ->distinct()
            ->orderBy('Type')
            ->pluck('Type');
        
        return Inertia::render('Admin/AccountCodes/Index', [
            'accountCodes' => $accountCodes,
            'filters' => $request->only(['search', 'type']),
            'types' => $types
        ]);
    }

    /**
     * Store a newly created account code.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'AcctCode' => 'required|string|max:12|unique:acct_codes,AcctCode',
            'Type' => 'required|integer',
            'SubType' => 'nullable|integer',
            'Description' => 'nullable|string|max:64',
            'AcctType' => 'nullable|integer',
            'HasSL' => 'required|boolean',
            'RelatedParentCode' => 'nullable|string|max:12',
            'CodeExt' => 'required|integer',
            'XOverride' => 'required|integer',
            'AcctClass' => 'nullable|integer',
            'AccumDepCode' => 'nullable|string|max:12',
            'CashFlowType' => 'required|integer',
            'IsExpAnalysis' => 'required|boolean',
            'isFinance' => 'nullable|boolean',
        ]);
        
        DB::beginTransaction();
        try {
            AcctCode::create($validated);
            DB::commit();
            
            return redirect()->route('admin.account-codes.index')
                ->with('success', 'Account code created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Failed to create account code: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display the specified account code.
     *
     * @param  string  $acctCode
     * @return \Inertia\Response
     */
    public function show($acctCode)
    {
        $accountCode = AcctCode::findOrFail($acctCode);
        
        return Inertia::render('Admin/AccountCodes/Show', [
            'accountCode' => $accountCode
        ]);
    }

    /**
     * Update the specified account code.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $acctCode
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $acctCode)
    {
        $accountCode = AcctCode::findOrFail($acctCode);
        
        $validated = $request->validate([
            'Type' => 'required|integer',
            'SubType' => 'nullable|integer',
            'Description' => 'nullable|string|max:64',
            'AcctType' => 'nullable|integer',
            'HasSL' => 'required|boolean',
            'RelatedParentCode' => 'nullable|string|max:12',
            'CodeExt' => 'required|integer',
            'XOverride' => 'required|integer',
            'AcctClass' => 'nullable|integer',
            'AccumDepCode' => 'nullable|string|max:12',
            'CashFlowType' => 'required|integer',
            'IsExpAnalysis' => 'required|boolean',
            'isFinance' => 'nullable|boolean',
        ]);
        
        DB::beginTransaction();
        try {
            $accountCode->update($validated);
            DB::commit();
            
            return redirect()->route('admin.account-codes.index')
                ->with('success', 'Account code updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Failed to update account code: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Remove the specified account code.
     *
     * @param  string  $acctCode
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($acctCode)
    {
        $accountCode = AcctCode::findOrFail($acctCode);
        
        DB::beginTransaction();
        try {
            $accountCode->delete();
            DB::commit();
            
            return redirect()->route('admin.account-codes.index')
                ->with('success', 'Account code deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Failed to delete account code: ' . $e->getMessage()]);
        }
    }
}
