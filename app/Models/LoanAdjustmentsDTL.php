<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanAdjustmentsDTL extends Model
{
    protected $primaryKey = 'AdjustDTLID';

    public $timestamps = false;

    protected $fillable = [
        'AdjustHDRID',
        'LoanPymtKey',
        'AcctCode',
        'TotalAmt',
        'PrincipalAmt',
        'InterestAmt',
        'PenaltyAmt',
        'FSav1Amt',
        'FSav2Amt',
        'FSav3Amt',
        'FSav4Amt',
        'FSav5Amt',
        'CLKey',
        'TransCode',
        'ClientCode',
        'BalAcctCode',
        'BalAmount',
        'PaymentTransCode',
        'PaymentDate',
    ];

    // Relationships
    public function header()
    {
        return $this->belongsTo(LoanAdjustmentsHDR::class, 'AdjustHDRID');
    }

    public function loanPayment()
    {
        return $this->belongsTo(LoanPymtDTL::class, 'LoanPymtKey');
    }

    public function account()
    {
        return $this->belongsTo(AcctCode::class, 'AcctCode', 'AcctCode');
    }

    public function balanceAccount()
    {
        return $this->belongsTo(AcctCode::class, 'BalAcctCode', 'AcctCode');
    }

    public function clientLoan()
    {
        return $this->belongsTo(ClientLoan::class, 'CLKey', 'CLKey');
    }

    public function client()
    {
        return $this->belongsTo(Clientele::class, 'ClientCode', 'ClientCode');
    }
}
