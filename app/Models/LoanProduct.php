<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoanProduct extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'LoanCode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'LoanCode', 'LoanType', 'Description', 'IRate',
        'FSav1', 'FSav2', 'FSav3', 'FSav4', 'FSav5',
        'FSav1Type', 'FSav2Type', 'FSav3Type', 'FSav4Type', 'FSav5Type',
        'InterestRate', 'Compounding', 'LoanAmount',
        'PrincipalMOP', 'InterestMOP', 'LoanTerm', 'TermQty',
        'GracePeriod', 'PenaltyRate', 'PenaltyComp',
        'ServCharge', 'ServChargeType',
        'DocStamp', 'DocStampType',
        'MRI', 'MRIType',
        'NotarialFee', 'NotarialFeeType',
        'FilingFee', 'FilingFeeType',
        'CIBI', 'CIBIType',
        'AFees', 'AFeesType',
        'CBAmount', 'CBType',
        'PenaltyGracePeriod', 'MinLoanAmount', 'MaxLoanAmount',
        'MaxTerm', 'MinTerm',
        'HasCollateral', 'HasCoMaker',
        'PrinUseMode', 'IntUseMode', 'SavingsUseMode',
        'LoanProdGroup', 'FixedRate', 'MinInterestRate', 'MaxInterestRate',
        'AutoPenalty', 'LoanTerminMaturity', 'PenaltyComputedPer',
        'PenaltyGL', 'AcctCode_Penalty', 'AcctCode_ServiceCharge',
        'AcctCode_DocumentStamp', 'AcctCode_MRI', 'AcctCode_NotarialFee',
        'AcctCode_FilingFee', 'AcctCode_CIBI', 'AcctCode_AFees', 'AcctCode_CB'
    ];

    protected $casts = [
        'InterestRate' => 'decimal:4',
        'LoanAmount' => 'decimal:4',
        'MinLoanAmount' => 'decimal:4',
        'MaxLoanAmount' => 'decimal:4',
        'PenaltyRate' => 'decimal:4',
        'ServCharge' => 'decimal:4',
        'DocStamp' => 'decimal:4',
        'MRI' => 'decimal:4',
        'NotarialFee' => 'decimal:4',
        'FilingFee' => 'decimal:4',
        'CIBI' => 'decimal:4',
        'AFees' => 'decimal:4',
        'CBAmount' => 'decimal:4',
        'PenaltyComputedPer' => 'decimal:4',
        'HasCollateral' => 'boolean',
        'HasCoMaker' => 'boolean',
        'FixedRate' => 'boolean',
        'AutoPenalty' => 'boolean',
        'LoanTerminMaturity' => 'boolean',
    ];

    // Relationship with loan applications
    public function loanApplications()
    {
        return $this->hasMany(LoanApplications::class, 'LoanType', 'LoanType');
    }

    // Helper methods
    public function getLoanTypeNameAttribute()
    {
        $types = [
            1 => 'Personal Loan',
            2 => 'Business Loan', 
            3 => 'Emergency Loan',
            4 => 'Educational Loan',
            5 => 'Housing Loan'
        ];
        return $types[$this->LoanType] ?? 'Unknown';
    }

    public function getFormattedInterestRateAttribute()
    {
        return number_format($this->InterestRate, 2) . '%';
    }

    public function getFormattedLoanAmountAttribute()
    {
        return '₱' . number_format($this->LoanAmount, 2);
    }

    public function getLoanRangeAttribute()
    {
        return '₱' . number_format($this->MinLoanAmount, 2) . ' - ₱' . number_format($this->MaxLoanAmount, 2);
    }

    public function getTermRangeAttribute()
    {
        return $this->MinTerm . ' - ' . $this->MaxTerm . ' months';
    }
}
