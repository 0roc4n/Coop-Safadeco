<?php

namespace App\Http\Controllers\Admin\AccountCodes;

use App\Http\Controllers\Controller;
use App\Models\AcctCode;
use App\Exports\AccountCodesExport;
use App\Imports\AccountCodesImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

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

    /**
     * Export account codes to CSV
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export()
    {
        return Excel::download(new AccountCodesExport, 'account_codes_' . date('Y-m-d_H-i-s') . '.csv');
    }

    /**
     * Import account codes from CSV
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:2048'
        ]);

        DB::beginTransaction();
        try {
            $import = new AccountCodesImport;
            $initialCount = AcctCode::count();
            
            Excel::import($import, $request->file('file'));

            $finalCount = AcctCode::count();
            $successCount = $finalCount - $initialCount;
            $errorCount = 0;
            $errors = [];

            // Get import failures
            if ($import->failures()->count() > 0) {
                foreach ($import->failures() as $failure) {
                    $errorCount++;
                    $errors[] = "Row {$failure->row()}: " . implode(', ', $failure->errors());
                }
            }

            // Get import errors
            if ($import->errors()->count() > 0) {
                foreach ($import->errors() as $error) {
                    $errorCount++;
                    $errors[] = $error;
                }
            }

            DB::commit();

            $message = "Import completed. ";
            if ($successCount > 0) {
                $message .= "{$successCount} records imported successfully. ";
            }
            if ($errorCount > 0) {
                $message .= "{$errorCount} records failed. ";
            }

            if ($errorCount > 0) {
                return redirect()->route('admin.account-codes.index')
                    ->with('warning', $message)
                    ->with('import_errors', array_slice($errors, 0, 10)); // Limit to first 10 errors
            } else {
                return redirect()->route('admin.account-codes.index')
                    ->with('success', $message);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Import failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Download sample CSV template
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadTemplate()
    {
        $headers = [
            'account_code',
            'type',
            'sub_type',
            'description',
            'account_type',
            'has_sl',
            'related_parent_code',
            'code_ext',
            'x_override',
            'account_class',
            'accumulated_depreciation_code',
            'cash_flow_type',
            'is_expense_analysis',
            'is_finance'
        ];

        $sampleData = [
            [
                'SAMPLE001',
                '1',
                '1',
                'Sample Account Description',
                '1',
                'Yes',
                '',
                '0',
                '0',
                '1',
                '',
                '0',
                'No',
                'No'
            ]
        ];

        $filename = 'account_codes_template.csv';
        $handle = fopen('php://temp', 'r+');

        // Add headers
        fputcsv($handle, $headers);

        // Add sample data
        foreach ($sampleData as $row) {
            fputcsv($handle, $row);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return response($content)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
