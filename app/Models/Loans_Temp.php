<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loans_Temp extends Model
{
    use HasFactory;

    protected $table = 'loans__temps';

    protected $fillable = [
        'CLKey', 'LACode', 'ClientCode', 'CenterGrpKey', 'AcctCode', 'Amount', 'DateReleased', 'CheckNum',
        'TransCode', 'BegDate', 'Collateral', 'Col_Value', 'CoMaker', 'Principal', 'Interest', 'ServCharge',
        'NetProc', 'EndDate', 'LoanPaid', 'FSav1', 'FSav2', 'FSav3', 'FSav4', 'FSav5', 'LoanBalance', 'StartSched',
        'FunderCode', 'PrgCode', 'LocCode', 'FCOCode', 'GracePeriod', 'GracePrd', 'PrinMOP', 'TermQty', 'TermTime',
        'MOP', 'IRate', 'IntMOP', 'IntComp', 'TermRes', 'PrinBal', 'IntBal', 'SavBal', 'TransCodeOR', 'TransCodeJV',
        'ClosedDate', 'RestructuredFrom', 'PymtTypeSav1', 'PymtTypeSav2', 'PymtTypeSav3', 'PymtTypeSav4', 'PymtTypeSav5',
        'PymtAmtSav1', 'PymtAmtSav2', 'PymtAmtSav3', 'PymtAmtSav4', 'PymtAmtSav5', 'LoanProceeds', 'PymtMode1',
        'PymtMode2', 'PymtMode3', 'PymtMode4', 'PymtMode5', 'LoanNumber'
    ];

    public function loanApplication()
    {
        return $this->belongsTo(LoanApplication::class, 'LACode', 'LACode');
    }

    public function clientLoan()
    {
        return $this->belongsTo(ClientLoan::class, 'CLKey', 'CLKey');
    }

    public function clientele()
    {
        return $this->belongsTo(Clientele::class, 'ClientCode', 'ClientCode');
    }
}
