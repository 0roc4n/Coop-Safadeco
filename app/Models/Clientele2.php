<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clientele2 extends Model
{
    use HasFactory;
    protected $fillable = [
        'ClientCode',
        'MembershipEntry',
        'PreOrientationDate',
        'MembershipOrientationConductedby',
        'Height',
        'Weight',
        'SSS',
        'TIN',
        'Shift',
        'DepartmentOrArea',
        'LocalNo',
        'Degree',
        'SpouseContactNo',
        'SpouseBirthday',
        'SpouseEducationalAttaintment',
        'SpouseDegree',
        'SpouseEmployer',
        'SpouseOfficeAddress',
        'FatherName',
        'FatherOcc',
        'FatherBirthday',
        'FatherOfficeAddress',
        'MotherName',
        'MotherOcc',
        'MotherBirthday',
        'MembershipStatus',
        'EmployerName',
        'OfficeAddress',
        'OfficeZip',
        'OfficePhone',
        'OtherSourceOfIncome',
        'OtherSourceMonthlyIncome',
        'ImagePhoto',
        'ImageSignature',
        'BODResNo',
        'DateApproved',
        'InitCapSubs',
        'NoOfShares',
        'amountSubs',
        'ReligionAffiliation',
        'BodResNoTerminate',
    ];

    public function clientele()
    {
        return $this->belongsTo(Clientele::class, 'ClientCode', 'ClientCode');
    }
}
