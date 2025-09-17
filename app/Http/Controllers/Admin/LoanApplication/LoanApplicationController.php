<?php

namespace App\Http\Controllers\Admin\LoanApplication;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoanApplicationRequest;
use App\Models\LoanApplications;
use App\Models\Clientele;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LoanApplicationController extends Controller
{
    /**
     * Display a listing of loan applications
     */
    public function index(Request $request)
    {
        $query = LoanApplications::with(['clientele:ClientCode,FirstName,LastName,MiddleName'])
            ->select([
                'LACode',
                'DtOfApp',
                'ClientCode',
                'Approved',
                'UserApproved',
                'ApproveDate',
                'LoanTotalPaid',
                'Remarks',
                'RatingScore',
                'LoanNumber',
                'LoanType',
                'LoanStatus',
                'created_at',
                'updated_at'
            ]);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('LACode', 'like', "%{$search}%")
                  ->orWhere('LoanNumber', 'like', "%{$search}%")
                  ->orWhere('Remarks', 'like', "%{$search}%")
                  ->orWhereHas('clientele', function ($clientQuery) use ($search) {
                      $clientQuery->where('FirstName', 'like', "%{$search}%")
                                ->orWhere('LastName', 'like', "%{$search}%")
                                ->orWhere('ClientCode', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('LoanStatus', $request->status);
        }

        // Filter by approval status
        if ($request->filled('approved') && $request->approved !== 'all') {
            $query->where('Approved', $request->approved);
        }

        // Filter by loan type
        if ($request->filled('loan_type') && $request->loan_type !== 'all') {
            $query->where('LoanType', $request->loan_type);
        }

        // Sort
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $loanApplications = $query->paginate(15)->withQueryString();

        // Get clients for dropdown
        $clients = Clientele::select('ClientCode', 'FirstName', 'LastName', 'MiddleName')
            ->orderBy('LastName')
            ->get()
            ->map(function ($client) {
                return [
                    'ClientCode' => $client->ClientCode,
                    'name' => trim("{$client->FirstName} {$client->MiddleName} {$client->LastName}")
                ];
            });

        // dd(json_encode($loanApplications));
        return Inertia::render('Admin/LoanApplication/Index', [
            'loanApplications' => $loanApplications,
            'clients' => $clients,
            'filters' => $request->only(['search', 'status', 'approved', 'loan_type']),
            'sort' => [
                'field' => $sortField,
                'direction' => $sortDirection
            ]
        ]);
    }

    /**
     * Show the form for creating a new loan application
     */
    public function create()
    {
        $clients = Clientele::select('ClientCode', 'FirstName', 'LastName', 'MiddleName')
            ->orderBy('LastName')
            ->get()
            ->map(function ($client) {
                return [
                    'ClientCode' => $client->ClientCode,
                    'name' => trim("{$client->FirstName} {$client->MiddleName} {$client->LastName}")
                ];
            });

        return Inertia::render('Admin/LoanApplication/Create', [
            'clients' => $clients
        ]);
    }

    /**
     * Store a newly created loan application
     */
    public function store(LoanApplicationRequest $request)
    {
        try {
            DB::beginTransaction();

            $loanApplication = LoanApplications::create([
                'DtOfApp' => $request->DtOfApp ? Carbon::parse($request->DtOfApp) : now(),
                'ClientCode' => $request->ClientCode,
                'Approved' => $request->Approved ?? 0,
                'UserApproved' => $request->Approved ? auth()->user()->name : null,
                'ApproveDate' => $request->Approved ? now() : null,
                'UserRefCd' => auth()->user()->id,
                'LoanTotalPaid' => false,
                'Remarks' => $request->Remarks,
                'RatingScore' => $request->RatingScore,
                'LoanNumber' => $request->LoanNumber,
                'LoanType' => $request->LoanType,
                'LoanStatus' => $request->LoanStatus ?? 1,
                'AppRemarks' => $request->AppRemarks,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.loan-applications.index')
                ->with('success', 'Loan application created successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create loan application: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified loan application
     */
    public function show(LoanApplications $loanApplication)
    {
        $loanApplication->load('clientele');
        
        return Inertia::render('Admin/LoanApplication/Show', [
            'loanApplication' => $loanApplication
        ]);
    }

    /**
     * Show the form for editing the specified loan application
     */
    public function edit(LoanApplications $loanApplication)
    {
        $clients = Clientele::select('ClientCode', 'FirstName', 'LastName', 'MiddleName')
            ->orderBy('LastName')
            ->get()
            ->map(function ($client) {
                return [
                    'ClientCode' => $client->ClientCode,
                    'name' => trim("{$client->FirstName} {$client->MiddleName} {$client->LastName}")
                ];
            });

        return Inertia::render('Admin/LoanApplication/Edit', [
            'loanApplication' => $loanApplication,
            'clients' => $clients
        ]);
    }

    /**
     * Update the specified loan application
     */
    public function update(LoanApplicationRequest $request, LoanApplications $loanApplication)
    {
        try {
            DB::beginTransaction();

            $updateData = [
                'DtOfApp' => $request->DtOfApp ? Carbon::parse($request->DtOfApp) : $loanApplication->DtOfApp,
                'ClientCode' => $request->ClientCode,
                'Approved' => $request->Approved ?? $loanApplication->Approved,
                'Remarks' => $request->Remarks,
                'RatingScore' => $request->RatingScore,
                'LoanNumber' => $request->LoanNumber,
                'LoanType' => $request->LoanType,
                'LoanStatus' => $request->LoanStatus,
                'AppRemarks' => $request->AppRemarks,
            ];

            // Update approval info if status changed
            if ($request->Approved && !$loanApplication->Approved) {
                $updateData['UserApproved'] = auth()->user()->name;
                $updateData['ApproveDate'] = now();
            } elseif (!$request->Approved && $loanApplication->Approved) {
                $updateData['UserApproved'] = null;
                $updateData['ApproveDate'] = null;
            }

            $loanApplication->update($updateData);

            DB::commit();

            return redirect()
                ->route('admin.loan-applications.index')
                ->with('success', 'Loan application updated successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update loan application: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified loan application
     */
    public function destroy(LoanApplications $loanApplication)
    {
        try {
            DB::beginTransaction();

            // Check if loan application can be deleted
            if ($loanApplication->LoanTotalPaid) {
                return redirect()
                    ->back()
                    ->withErrors(['error' => 'Cannot delete a loan application that has been paid.']);
            }

            $loanApplication->delete();

            DB::commit();

            return redirect()
                ->route('admin.loan-applications.index')
                ->with('success', 'Loan application deleted successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->withErrors(['error' => 'Failed to delete loan application: ' . $e->getMessage()]);
        }
    }

    /**
     * Approve or reject loan application
     */
    public function updateApproval(Request $request, LoanApplications $loanApplication)
    {
        $request->validate([
            'approved' => 'required|boolean',
            'remarks' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $updateData = [
                'Approved' => $request->approved,
                'UserApproved' => $request->approved ? auth()->user()->name : null,
                'ApproveDate' => $request->approved ? now() : null,
                'LoanStatus' => $request->approved ? 2 : 3, // 2 = Approved, 3 = Rejected
            ];

            if ($request->filled('remarks')) {
                $updateData['AppRemarks'] = $request->remarks;
            }

            $loanApplication->update($updateData);

            DB::commit();

            $status = $request->approved ? 'approved' : 'rejected';
            return redirect()
                ->back()
                ->with('success', "Loan application has been {$status} successfully!");

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->withErrors(['error' => 'Failed to update approval status: ' . $e->getMessage()]);
        }
    }

    /**
     * Search clients for autocomplete
     */
    public function searchClients(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $clients = Clientele::select('ClientCode', 'FirstName', 'LastName', 'MiddleName')
            ->where(function ($q) use ($query) {
                $q->where('ClientCode', 'like', "%{$query}%")
                  ->orWhere('FirstName', 'like', "%{$query}%")
                  ->orWhere('LastName', 'like', "%{$query}%")
                  ->orWhere('MiddleName', 'like', "%{$query}%");
            })
            ->limit(10)
            ->get()
            ->map(function ($client) {
                return [
                    'ClientCode' => $client->ClientCode,
                    'name' => trim("{$client->FirstName} {$client->MiddleName} {$client->LastName}")
                ];
            });

        return response()->json($clients);
    }
}