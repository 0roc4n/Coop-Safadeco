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
				'ClientCode','LastName','FirstName','MiddleName','DateOfMembership','ClientType','Addr1','TelNum','DtBirth','Sex','MonthlySalary','Occupation','MFee_amt','MaxShareCapital','created_at','updated_at'
			])
			->with('clienteleDetails')
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
			// Clientele (main) fields
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

			// Clientele2 (details) fields
			'MembershipEntry' => 'nullable|string|max:5',
			'PreOrientationDate' => 'nullable|date',
			'MembershipOrientationConductedby' => 'nullable|string|max:64',
			'Height' => 'nullable|string|max:10',
			'Weight' => 'nullable|string|max:10',
			'SSS' => 'nullable|string|max:20',
			'TIN' => 'nullable|string|max:20',
			'Shift' => 'nullable|string|max:20',
			'DepartmentOrArea' => 'nullable|string|max:32',
			'LocalNo' => 'nullable|string|max:20',
			'Degree' => 'nullable|string|max:64',
			'SpouseContactNo' => 'nullable|string|max:64',
			'SpouseBirthday' => 'nullable|date',
			'SpouseEducationalAttaintment' => 'nullable|string|max:64',
			'SpouseDegree' => 'nullable|string|max:64',
			'SpouseEmployer' => 'nullable|string|max:64',
			'SpouseOfficeAddress' => 'nullable|string|max:64',
			'FatherName' => 'nullable|string|max:64',
			'FatherOcc' => 'nullable|string|max:64',
			'FatherBirthday' => 'nullable|date',
			'FatherOfficeAddress' => 'nullable|string|max:64',
			'MotherName' => 'nullable|string|max:64',
			'MotherOcc' => 'nullable|string|max:64',
			'MotherBirthday' => 'nullable|date',
			'MembershipStatus' => 'nullable|string|max:5',
			'EmployerName' => 'nullable|string|max:30',
			'OfficeAddress' => 'nullable|string|max:100',
			'OfficeZip' => 'nullable|string|max:30',
			'OfficePhone' => 'nullable|string|max:30',
			'OtherSourceOfIncome' => 'nullable|string|max:30',
			'OtherSourceMonthlyIncome' => 'nullable|string|max:30',
			'BODResNo' => 'nullable|string|max:50',
			'DateApproved' => 'nullable|date',
			'InitCapSubs' => 'nullable|integer|min:0',
			'NoOfShares' => 'nullable|integer|min:0',
			'amountSubs' => 'nullable|numeric|min:0',
			'ReligionAffiliation' => 'nullable|string|max:150',
			'BodResNoTerminate' => 'nullable|string|max:100',
		]);

		DB::transaction(function () use ($validated) {
			// Create main record
			$clienteleData = array_intersect_key($validated, array_flip([
				'ClientCode','LastName','FirstName','MiddleName','DateOfMembership','ClientType','Addr1','TelNum','DtBirth','Sex','MonthlySalary','Occupation','MFee_amt','MaxShareCapital'
			]));
			Clientele::create($clienteleData);

			// Create details if any provided
			$clientele2Data = array_intersect_key($validated, array_flip([
				'MembershipEntry','PreOrientationDate','MembershipOrientationConductedby','Height','Weight','SSS','TIN','Shift','DepartmentOrArea','LocalNo','Degree','SpouseContactNo','SpouseBirthday','SpouseEducationalAttaintment','SpouseDegree','SpouseEmployer','SpouseOfficeAddress','FatherName','FatherOcc','FatherBirthday','FatherOfficeAddress','MotherName','MotherOcc','MotherBirthday','MembershipStatus','EmployerName','OfficeAddress','OfficeZip','OfficePhone','OtherSourceOfIncome','OtherSourceMonthlyIncome','BODResNo','DateApproved','InitCapSubs','NoOfShares','amountSubs','ReligionAffiliation','BodResNoTerminate'
			]));
			if (!empty($clientele2Data)) {
				$clientele2Data['ClientCode'] = $clienteleData['ClientCode'];
				Clientele2::create($clientele2Data);
			}
		});

		return back()->with('success','Client created');
	}

	public function update(Request $request, $clientCode)
	{
		$validated = $request->validate([
			// Clientele (main) fields
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

			// Clientele2 (details) fields
			'MembershipEntry' => 'nullable|string|max:5',
			'PreOrientationDate' => 'nullable|date',
			'MembershipOrientationConductedby' => 'nullable|string|max:64',
			'Height' => 'nullable|string|max:10',
			'Weight' => 'nullable|string|max:10',
			'SSS' => 'nullable|string|max:20',
			'TIN' => 'nullable|string|max:20',
			'Shift' => 'nullable|string|max:20',
			'DepartmentOrArea' => 'nullable|string|max:32',
			'LocalNo' => 'nullable|string|max:20',
			'Degree' => 'nullable|string|max:64',
			'SpouseContactNo' => 'nullable|string|max:64',
			'SpouseBirthday' => 'nullable|date',
			'SpouseEducationalAttaintment' => 'nullable|string|max:64',
			'SpouseDegree' => 'nullable|string|max:64',
			'SpouseEmployer' => 'nullable|string|max:64',
			'SpouseOfficeAddress' => 'nullable|string|max:64',
			'FatherName' => 'nullable|string|max:64',
			'FatherOcc' => 'nullable|string|max:64',
			'FatherBirthday' => 'nullable|date',
			'FatherOfficeAddress' => 'nullable|string|max:64',
			'MotherName' => 'nullable|string|max:64',
			'MotherOcc' => 'nullable|string|max:64',
			'MotherBirthday' => 'nullable|date',
			'MembershipStatus' => 'nullable|string|max:5',
			'EmployerName' => 'nullable|string|max:30',
			'OfficeAddress' => 'nullable|string|max:100',
			'OfficeZip' => 'nullable|string|max:30',
			'OfficePhone' => 'nullable|string|max:30',
			'OtherSourceOfIncome' => 'nullable|string|max:30',
			'OtherSourceMonthlyIncome' => 'nullable|string|max:30',
			'BODResNo' => 'nullable|string|max:50',
			'DateApproved' => 'nullable|date',
			'InitCapSubs' => 'nullable|integer|min:0',
			'NoOfShares' => 'nullable|integer|min:0',
			'amountSubs' => 'nullable|numeric|min:0',
			'ReligionAffiliation' => 'nullable|string|max:150',
			'BodResNoTerminate' => 'nullable|string|max:100',
		]);

		DB::transaction(function () use ($validated, $clientCode) {
			$clientele = Clientele::findOrFail($clientCode);

			// Update main
			$clienteleData = array_intersect_key($validated, array_flip([
				'LastName','FirstName','MiddleName','DateOfMembership','ClientType','Addr1','TelNum','DtBirth','Sex','MonthlySalary','Occupation','MFee_amt','MaxShareCapital'
			]));
			$clientele->update($clienteleData);

			// Upsert details
			$clientele2Data = array_intersect_key($validated, array_flip([
				'MembershipEntry','PreOrientationDate','MembershipOrientationConductedby','Height','Weight','SSS','TIN','Shift','DepartmentOrArea','LocalNo','Degree','SpouseContactNo','SpouseBirthday','SpouseEducationalAttaintment','SpouseDegree','SpouseEmployer','SpouseOfficeAddress','FatherName','FatherOcc','FatherBirthday','FatherOfficeAddress','MotherName','MotherOcc','MotherBirthday','MembershipStatus','EmployerName','OfficeAddress','OfficeZip','OfficePhone','OtherSourceOfIncome','OtherSourceMonthlyIncome','BODResNo','DateApproved','InitCapSubs','NoOfShares','amountSubs','ReligionAffiliation','BodResNoTerminate'
			]));
			if (!empty($clientele2Data)) {
				$clientele->clienteleDetails()->updateOrCreate(
					['ClientCode' => $clientCode],
					$clientele2Data
				);
			}
		});

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


