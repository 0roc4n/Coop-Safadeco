<?php

namespace App\Http\Controllers\Clerk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Clientele;
use App\Models\Clientele2;
use Illuminate\Support\Facades\DB;

class ClienteleController extends Controller
{
	public function index(Request $request)
	{
		$search = $request->query('search');
		$query = Clientele::query()
			->select([
				'ClientCode','LastName','FirstName','MiddleName','DateOfMembership','ClientType','Addr1','TelNum','DtBirth','Sex','MonthlySalary','Occupation','created_at','updated_at'
			])
			->orderBy('LastName','asc');

		if ($search) {
			$query->where(function($q) use ($search) {
				$q->where('ClientCode','like',"%{$search}%")
					->orWhere('LastName','like',"%{$search}%")
					->orWhere('FirstName','like',"%{$search}%");
			});
		}

		$clienteles = $query->paginate(15)->withQueryString();

		$statistics = [
			'total_clients' => Clientele::count(),
			'new_members_this_month' => Clientele::whereMonth('DateOfMembership', now()->month)->whereYear('DateOfMembership', now()->year)->count(),
		];

		return Inertia::render('Clerk/Clientele/Index', [
			'clienteles' => $clienteles,
			'statistics' => $statistics,
			'filters' => [ 'search' => $search ]
		]);
	}

	public function store(Request $request)
	{
		$validated = $request->validate([
			'ClientCode' => 'required|string|max:10|unique:clienteles,ClientCode',
			'LastName' => 'required|string|max:70',
			'FirstName' => 'required|string|max:70',
			'MiddleName' => 'nullable|string|max:70',
			'DateOfMembership' => 'required|date',
			'ClientType' => 'required|integer',
			'Addr1' => 'nullable|string|max:150',
			'TelNum' => 'nullable|string|max:64',
			'DtBirth' => 'nullable|date',
			'Sex' => 'nullable|boolean',
			'MonthlySalary' => 'nullable|numeric|min:0',
			'Occupation' => 'nullable|string|max:50',
			'MFee_amt' => 'nullable|numeric|min:0',
			'MaxShareCapital' => 'nullable|numeric|min:0',
		]);

		DB::transaction(function () use ($validated) {
			Clientele::create($validated);
		});

		return back()->with('success','Client created');
	}

	public function update(Request $request, $clientCode)
	{
		$validated = $request->validate([
			'LastName' => 'required|string|max:70',
			'FirstName' => 'required|string|max:70',
			'MiddleName' => 'nullable|string|max:70',
			'DateOfMembership' => 'required|date',
			'ClientType' => 'required|integer',
			'Addr1' => 'nullable|string|max:150',
			'TelNum' => 'nullable|string|max:64',
			'DtBirth' => 'nullable|date',
			'Sex' => 'nullable|boolean',
			'MonthlySalary' => 'nullable|numeric|min:0',
			'Occupation' => 'nullable|string|max:50',
			'MFee_amt' => 'nullable|numeric|min:0',
			'MaxShareCapital' => 'nullable|numeric|min:0',
		]);

		$clientele = Clientele::findOrFail($clientCode);
		$clientele->update($validated);

		return back()->with('success','Client updated');
	}

	public function destroy($clientCode)
	{
		DB::transaction(function () use ($clientCode) {
			$clientele = Clientele::findOrFail($clientCode);
			if ($clientele->clienteleDetails) {
				$clientele->clienteleDetails()->delete();
			}
			$clientele->delete();
		});

		return back()->with('success','Client deleted');
	}
}


