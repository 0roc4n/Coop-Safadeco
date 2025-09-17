<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OldLoans extends Model
{
    protected $table = 'old_loans';

    // If not using auto-incrementing ID
    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'CLKey',
        'LACode',
        'ClientCode',
        'CenterGrpKey',
        'AcctCode',
        'Amount',
        'DateReleased',
        'CheckNum',
        'TransCode',
        'BegDate',
        'Collateral',
        'Col_Value',
        'CoMaker',
        'Principal',
        'Interest',
        'ServCharge',
        'NetProc',
        'EndDate',
        'LoanPaid',
        'FSav1',
        'FSav2',
        'FSav3',
        'FSav4',
        'FSav5',
        'LoanBalance',
        'StartSched',
        'FunderCode',
        'PrgCode',
        'LocCode',
        'FCOCode',
        'GracePeriod',
        'GracePrd',
        'PrinMOP',
        'TermQty',
        'TermTime',
        'MOP',
        'IRate',
        'IntMOP',
        'IntComp',
        'TermRes',
        'PrinBal',
        'IntBal',
        'SavBal',
        'TransCodeOR',
        'TransCodeJV',
        'ClosedDate',
        'RestructuredFrom',
        'PymtTypeSav1',
        'PymtTypeSav2',
        'PymtTypeSav3',
        'PymtTypeSav4',
        'PymtTypeSav5',
        'PymtAmtSav1',
        'PymtAmtSav2',
        'PymtAmtSav3',
        'PymtAmtSav4',
        'PymtAmtSav5',
        'LoanProceeds',
        'PymtMode1',
        'PymtMode2',
        'PymtMode3',
        'PymtMode4',
        'PymtMode5',
        'LoanNumber',
    ];

    /** Relationships */

    public function client()
    {
        return $this->belongsTo(Clientele::class, 'ClientCode', 'ClientCode');
    }

    public function clientLoan()
    {
        return $this->belongsTo(ClientLoans::class, 'CLKey', 'CLKey');
    }

    public function loanApplication()
    {
        return $this->belongsTo(LoanApplications::class, 'LACode', 'LACode');
    }

    public function acctCode()
    {
        return $this->belongsTo(AcctCode::class, 'AcctCode', 'AcctCode');
    }
}
