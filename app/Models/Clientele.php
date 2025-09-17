<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clientele extends Model
{
    protected $primaryKey = 'ClientCode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'ClientCode',
        'CenterGrpKey',
        'LastName',
        'FirstName',
        'MiddleName',
        'DateOfMembership',
        'ClientType',
        'ClientClass',
        'EmployeeType',
        'Addr1',
        'Addr2',
        'Addr3',
        'TelNum',
        'PlBirth',
        'DtBirth',
        'Sex',
        'SpouseName',
        'EduAtt',
        'CivStatus',
        'DtOfTerminate',
        'UserRefCD',
        'MonthlySalary',
        'SpouseOcc',
        'SpouseMonSal',
        'MemberType',
        'Occupation',
        'Office',
        'Department',
        'MFee_amt',
        'BankAcctNo',
        'BankBranch',
        'EmploymentDate',
        'ResignationDate',
        'MaxShareCapital',
    ];

    public function clienteleDetails()
    {
        return $this->hasOne(Clientele2::class, 'ClientCode', 'ClientCode');
    }

    public function loanApplications()
    {
        return $this->hasMany(LoanApplications::class, 'ClientCode', 'ClientCode');
    }
}
