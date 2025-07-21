<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Clientele2 extends Model
{
    use HasFactory;

    protected $table = 'clientele2';
    protected $primaryKey = 'ID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

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

    protected $casts = [
        'PreOrientationDate' => 'datetime',
        'SpouseBirthday' => 'datetime',
        'FatherBirthday' => 'datetime',
        'MotherBirthday' => 'datetime',
        'DateApproved' => 'datetime',
        'amountSubs' => 'decimal:4',
        'ImagePhoto' => 'string', // or 'base64_encoded_string' or null, depending on how you handle blobs
        'ImageSignature' => 'string', // same as above
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Clientele::class, 'ClientCode', 'ClientCode');
    }
}
