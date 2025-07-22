<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanProduct extends Model
{
    protected $primaryKey = 'LoanCode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

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
}
