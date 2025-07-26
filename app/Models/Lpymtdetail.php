<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lpymtdetail extends Model
{
    protected $table = 'lpymtdetails';
    protected $fillable = [
        'LoanPymtKey',
        'AcctCode',
        'Amount',
        'CheckNo',
        'PrincipalAmt',
        'InterestAmt',
        'FSav1Amt',
        'FSav2Amt',
        'FSav3Amt',
        'FSav4Amt',
        'FSav5Amt',
        'PenaltyAmt',
        'PymtType',
        'OthPymt',
        'BMaintainAmt',
        'DormantAmt',
        'LnPrnYN',
        'LnLine',
        'LnPage',
        'LnBook',
        'CLKey',
        'ClientCode',
        'RebateAmt',
        'IntAftrMat',
        'PenaltyAftMat',
    ];
}
