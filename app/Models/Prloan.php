<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prloan extends Model
{
    protected $table = 'prloans';

    protected $fillable = [
        'AcctCode', 'LnDesc', 'LendMeth', 'PrinMOP', 'IRate', 'IntMOP',
        'IntComp', 'TermQty', 'TermTime', 'MOP', 'FunderCode', 'TermRes',
        'RtPassScore', 'UserRefCd', 'FSav1', 'FSav2', 'FSav3', 'FSav4', 'FSav5',
        'SChargeType', 'SChargeAmt', 'InterestAcct', 'GracePeriod',
        'PymtTypeSav1', 'PymtAmtSav1', 'PymtMode1', 'AllocTypeSav1',
        'PymtTypeSav2', 'PymtAmtSav2', 'PymtMode2', 'AllocTypeSav2',
        'PymtTypeSav3', 'PymtAmtSav3', 'PymtMode3', 'AllocTypeSav3',
        'PymtTypeSav4', 'PymtAmtSav4', 'PymtMode4', 'AllocTypeSav4',
        'PymtTypeSav5', 'PymtAmtSav5', 'PymtMode5', 'AllocTypeSav5',
        'IntAfterMaturity_YN', 'MaturityIntRate', 'IncIntLOBal_YN', 'MaturityIntType',
        'UpfrontBasis1', 'UpfrontBasis2', 'UpfrontBasis3', 'UpfrontBasis4', 'UpfrontBasis5',
        'AccrualType', 'EColChargePenalty', 'EColPenaltyType', 'EColPenaltyRate',
        'EColPenaltyBasis', 'EColPenaltyFreq', 'EColIncInterest',
        'AfMatChargePenalty', 'AfMatPenaltyType', 'AfMatPenaltyRate',
        'AfMatPenaltyBasis', 'AfMatPenaltyFreq', 'AfMatIncInterest',
        'allowmultiple', 'ApplyInterestToFld', 'IsAddInterest', 'IsAutoOR',
        'PenaltyRateBasis'
    ];
}
