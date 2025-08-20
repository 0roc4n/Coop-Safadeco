<?php

namespace App\Http\Controllers\Admin\Clientele;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Clientele;
use App\Models\Clientele2;
use Illuminate\Support\Facades\DB;

class ClienteleController extends Controller
{
    public function index(){
        $clienteles = Clientele::with('clienteleDetails')
            ->select([
                'ClientCode',
                'LastName',
                'FirstName',
                'MiddleName',
                'DateOfMembership',
                'ClientType',
                'Addr1',
                'TelNum',
                'DtBirth',
                'Sex',
                'MonthlySalary',
                'Occupation',
                'created_at',
                'updated_at'
            ])
            ->with('clienteleDetails')
            ->orderBy('LastName', 'asc')
            ->paginate(50);
            // dd($clienteles);
        return Inertia::render('Admin/Clientele/Index', [
            'clienteles' => $clienteles
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Basic Clientele fields
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
            'SpouseName' => 'nullable|string|max:64',
            'SpouseOcc' => 'nullable|string|max:50',
            'SpouseMonSal' => 'nullable|numeric|min:0',
            'CivStatus' => 'nullable|integer',
            'EduAtt' => 'nullable|integer',
            'MFee_amt' => 'required|numeric|min:0',
            'MaxShareCapital' => 'required|numeric|min:0',
            
            // Clientele2 fields
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
            'BODResNo' => 'required|string|max:50',
            'DateApproved' => 'required|date',
            'InitCapSubs' => 'required|integer|min:0',
            'NoOfShares' => 'required|integer|min:0',
            'amountSubs' => 'required|numeric|min:0',
            'ReligionAffiliation' => 'required|string|max:150',
            'BodResNoTerminate' => 'nullable|string|max:100',
        ]);

        try {
            DB::beginTransaction();

            // Create main clientele record
            $clienteleData = array_intersect_key($validated, array_flip([
                'ClientCode', 'LastName', 'FirstName', 'MiddleName', 'DateOfMembership',
                'ClientType', 'Addr1', 'TelNum', 'DtBirth', 'Sex', 'MonthlySalary',
                'Occupation', 'SpouseName', 'SpouseOcc', 'SpouseMonSal', 'CivStatus', 'EduAtt',
                'MFee_amt', 'MaxShareCapital'
            ]));

            $clientele = Clientele::create($clienteleData);

            // Create detailed clientele record
            $clientele2Data = array_intersect_key($validated, array_flip([
                'MembershipEntry', 'PreOrientationDate', 'MembershipOrientationConductedby',
                'Height', 'Weight', 'SSS', 'TIN', 'Shift', 'DepartmentOrArea', 'LocalNo',
                'Degree', 'SpouseContactNo', 'SpouseBirthday', 'SpouseEducationalAttaintment',
                'SpouseDegree', 'SpouseEmployer', 'SpouseOfficeAddress', 'FatherName',
                'FatherOcc', 'FatherBirthday', 'FatherOfficeAddress', 'MotherName',
                'MotherOcc', 'MotherBirthday', 'MembershipStatus', 'EmployerName',
                'OfficeAddress', 'OfficeZip', 'OfficePhone', 'OtherSourceOfIncome',
                'OtherSourceMonthlyIncome', 'BODResNo', 'DateApproved', 'InitCapSubs',
                'NoOfShares', 'amountSubs', 'ReligionAffiliation', 'BodResNoTerminate'
            ]));

            $clientele2Data['ClientCode'] = $validated['ClientCode'];
            Clientele2::create($clientele2Data);

            DB::commit();

            return back()->with('success', 'Client created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to create client: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, $clientCode)
    {
        $validated = $request->validate([
            // Basic Clientele fields
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
            'SpouseName' => 'nullable|string|max:64',
            'SpouseOcc' => 'nullable|string|max:50',
            'SpouseMonSal' => 'nullable|numeric|min:0',
            'CivStatus' => 'nullable|integer',
            'EduAtt' => 'nullable|integer',
            'MFee_amt' => 'required|numeric|min:0',
            'MaxShareCapital' => 'required|numeric|min:0',
            
            // Clientele2 fields
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
            'BODResNo' => 'required|string|max:50',
            'DateApproved' => 'required|date',
            'InitCapSubs' => 'required|integer|min:0',
            'NoOfShares' => 'required|integer|min:0',
            'amountSubs' => 'required|numeric|min:0',
            'ReligionAffiliation' => 'required|string|max:150',
            'BodResNoTerminate' => 'nullable|string|max:100',
        ]);

        try {
            DB::beginTransaction();

            $clientele = Clientele::findOrFail($clientCode);

            // Update main clientele record
            $clienteleData = array_intersect_key($validated, array_flip([
                'LastName', 'FirstName', 'MiddleName', 'DateOfMembership',
                'ClientType', 'Addr1', 'TelNum', 'DtBirth', 'Sex', 'MonthlySalary',
                'Occupation', 'SpouseName', 'SpouseOcc', 'SpouseMonSal', 'CivStatus', 'EduAtt',
                'MFee_amt', 'MaxShareCapital'
            ]));

            $clientele->update($clienteleData);

            // Update or create detailed clientele record
            $clientele2Data = array_intersect_key($validated, array_flip([
                'MembershipEntry', 'PreOrientationDate', 'MembershipOrientationConductedby',
                'Height', 'Weight', 'SSS', 'TIN', 'Shift', 'DepartmentOrArea', 'LocalNo',
                'Degree', 'SpouseContactNo', 'SpouseBirthday', 'SpouseEducationalAttaintment',
                'SpouseDegree', 'SpouseEmployer', 'SpouseOfficeAddress', 'FatherName',
                'FatherOcc', 'FatherBirthday', 'FatherOfficeAddress', 'MotherName',
                'MotherOcc', 'MotherBirthday', 'MembershipStatus', 'EmployerName',
                'OfficeAddress', 'OfficeZip', 'OfficePhone', 'OtherSourceOfIncome',
                'OtherSourceMonthlyIncome', 'BODResNo', 'DateApproved', 'InitCapSubs',
                'NoOfShares', 'amountSubs', 'ReligionAffiliation', 'BodResNoTerminate'
            ]));

            $clientele->clienteleDetails()->updateOrCreate(
                ['ClientCode' => $clientCode],
                $clientele2Data
            );

            DB::commit();

            return back()->with('success', 'Client updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update client: ' . $e->getMessage()]);
        }
    }

    public function destroy($clientCode)
    {
        try {
            DB::beginTransaction();

            $clientele = Clientele::findOrFail($clientCode);
            
            // Delete detailed record first due to foreign key constraint
            $clientele->clienteleDetails()->delete();
            
            // Delete main clientele record
            $clientele->delete();

            DB::commit();

            return back()->with('success', 'Client deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to delete client: ' . $e->getMessage()]);
        }
    }
}