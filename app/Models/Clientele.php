<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Clientele extends Model
{
    use HasFactory;

    protected $table = 'clientele';
    protected $primaryKey = 'ClientCode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false; // No created_at, updated_at columns

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

    protected $casts = [
        'DateOfMembership' => 'datetime',
        'DtBirth' => 'datetime',
        'Sex' => 'boolean',
        'DtOfTerminate' => 'datetime',
        'MonthlySalary' => 'decimal:4',
        'SpouseMonSal' => 'decimal:4',
        'MFee_amt' => 'decimal:4',
        'EmploymentDate' => 'datetime',
        'ResignationDate' => 'datetime',
        'MaxShareCapital' => 'decimal:4',
    ];

    /**
     * Get the center group that the client belongs to.
     */
    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class, 'CenterGrpKey', 'CenterCode');
    }

    // We'll add relationships for clientele2, clientloans, etc., later as we define those models.
    /**
     * Get the extended client details associated with the client.
     */
    public function clientele2(): HasOne
    {
        return $this->hasOne(Clientele2::class, 'ClientCode', 'ClientCode');
    }

    /**
     * Get the loans for the client.
     */
    public function loans(): HasMany
    {
        return $this->hasMany(ClientLoan::class, 'ClientCode', 'ClientCode');
    }

    /**
     * Get the historical office assignments for the client.
     */
    public function clientHistory(): HasMany
    {
        return $this->hasMany(ClientHistory::class, 'ClientCode', 'ClientCode');
    }

    /**
     * Get the CASA client savings accounts for the client.
     */
    public function casaSavings(): HasMany
    {
        return $this->hasMany(CasaClientSavings::class, 'ClientCode', 'ClientCode');
    }

    /**
     * Get the CASA debit/credit memos for the client.
     */
    public function casaDebitCreditMemos(): HasMany
    {
        return $this->hasMany(CasaDebitCreditMemo::class, 'ClientCode', 'ClientCode');
    }

    /**
     * Get the certificate details for the client.
     */
    public function certificateDetails(): HasMany
    {
        return $this->hasMany(CertificatesDtl::class, 'ClientCode', 'ClientCode');
    }

    /**
     * Get the CIF clientele record for the client.
     */
    public function cifClientele(): HasOne
    {
        return $this->hasOne(CifClientele::class, 'ClientCode', 'ClientCode');
    }

    /**
     * Get the co-maker relationships where this client is the co-maker.
     */
    public function comakerForLoans(): HasMany
    {
        return $this->hasMany(ClientComaker::class, 'ClientCode', 'ClientCode');
    }

}
