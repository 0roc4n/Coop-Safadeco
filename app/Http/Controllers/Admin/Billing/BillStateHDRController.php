<?php

namespace App\Http\Controllers\Admin\Billing;

use App\Http\Controllers\Controller;
use App\Models\BillingStatementHdr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class BillStateHDRController extends Controller
{
    /**
     * Display a listing of the billing statements.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $query = BillingStatementHdr::query()
            ->select([
                'BillingHdrID', 
                'BillingDate', 
                'DocumentNo',
                'Remarks',
                'PymtDate',
                'DateGenerated',
                'TransCode'
            ]);

        // Handle search
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('DocumentNo', 'like', "%{$searchTerm}%")
                  ->orWhere('Remarks', 'like', "%{$searchTerm}%")
                  ->orWhere('TransCode', 'like', "%{$searchTerm}%");
            });
        }

        // Handle date filtering
        if ($request->has('dateFilter')) {
            $now = Carbon::now();
            
            switch ($request->dateFilter) {
                case 'today':
                    $query->whereDate('BillingDate', $now->toDateString());
                    break;
                case 'week':
                    $query->whereBetween('BillingDate', [
                        $now->startOfWeek()->toDateString(),
                        $now->endOfWeek()->toDateString()
                    ]);
                    break;
                case 'month':
                    $query->whereMonth('BillingDate', $now->month)
                          ->whereYear('BillingDate', $now->year);
                    break;
                case 'year':
                    $query->whereYear('BillingDate', $now->year);
                    break;
            }
        }

        // Sort by most recent first
        $billingStatements = $query->latest('BillingDate')
            ->paginate(10)
            ->withQueryString()
            ->through(function ($statement) {
                return [
                    'id' => $statement->BillingHdrID,
                    'billingDate' => $statement->BillingDate,
                    'documentNo' => $statement->DocumentNo,
                    'remarks' => $statement->Remarks,
                    'pymtDate' => $statement->PymtDate,
                    'dateGenerated' => $statement->DateGenerated,
                    'transCode' => $statement->TransCode,
                ];
            });

        return Inertia::render('Admin/Billing/BillStateHDR/Index', [
            'billingStatements' => $billingStatements,
            'filters' => $request->only(['search', 'dateFilter']),
        ]);
    }

    /**
     * Store a newly created billing statement.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'billingDate' => 'required|date',
            'documentNo' => 'nullable|string|max:15|unique:billingstatementhdr,DocumentNo',
            'remarks' => 'nullable|string|max:120',
            'pymtDate' => 'nullable|date',
            'transCode' => 'nullable|string|max:20',
        ]);

        // Begin transaction to ensure data integrity
        DB::beginTransaction();
        try {
            BillingStatementHdr::create([
                'BillingDate' => $validated['billingDate'],
                'DocumentNo' => $validated['documentNo'],
                'Remarks' => $validated['remarks'],
                'PymtDate' => $validated['pymtDate'],
                'DateGenerated' => now(),
                'TransCode' => $validated['transCode'],
            ]);
            
            DB::commit();
            
            return redirect()->route('billing.statements.index')
                ->with('success', 'Billing statement created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'An error occurred while creating the billing statement.'])
                ->withInput();
        }
    }

    /**
     * Display the specified billing statement.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function show($id)
    {
        $billingStatement = BillingStatementHdr::findOrFail($id);

        return Inertia::render('Admin/Billing/BillStateHDR/Show', [
            'billingStatement' => [
                'id' => $billingStatement->BillingHdrID,
                'billingDate' => $billingStatement->BillingDate,
                'documentNo' => $billingStatement->DocumentNo,
                'remarks' => $billingStatement->Remarks,
                'pymtDate' => $billingStatement->PymtDate,
                'dateGenerated' => $billingStatement->DateGenerated,
                'transCode' => $billingStatement->TransCode,
            ],
        ]);
    }

    /**
     * Update the specified billing statement.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $billingStatement = BillingStatementHdr::findOrFail($id);

        $validated = $request->validate([
            'billingDate' => 'required|date',
            'documentNo' => [
                'nullable',
                'string',
                'max:15',
                Rule::unique('billingstatementhdr', 'DocumentNo')->ignore($id, 'BillingHdrID'),
            ],
            'remarks' => 'nullable|string|max:120',
            'pymtDate' => 'nullable|date',
            'transCode' => 'nullable|string|max:20',
        ]);

        // Begin transaction to ensure data integrity
        DB::beginTransaction();
        try {
            $billingStatement->update([
                'BillingDate' => $validated['billingDate'],
                'DocumentNo' => $validated['documentNo'],
                'Remarks' => $validated['remarks'],
                'PymtDate' => $validated['pymtDate'],
                'TransCode' => $validated['transCode'],
            ]);
            
            DB::commit();
            
            return redirect()->route('billing.statements.index')
                ->with('success', 'Billing statement updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'An error occurred while updating the billing statement.'])
                ->withInput();
        }
    }

    /**
     * Remove the specified billing statement.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $billingStatement = BillingStatementHdr::findOrFail($id);

        // Begin transaction to ensure data integrity
        DB::beginTransaction();
        try {
            $billingStatement->delete();
            
            DB::commit();
            
            return redirect()->route('billing.statements.index')
                ->with('success', 'Billing statement deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'An error occurred while deleting the billing statement.']);
        }
    }
}
