<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientLoans extends Model
{
    use HasFactory;

    protected $primaryKey = 'CLKey';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'CLKey', 'LACode', 'ClientCode', 'AcctCode', 'Amount', 'DateReleased', 'CheckNum', 'TransCode',
        'BegDate', 'Collateral', 'Col_Value', 'CoMaker', 'Principal', 'Interest', 'ServCharge', 'NetProc',
        'EndDate', 'LoanPaid', 'FSav1', 'FSav2', 'FSav3', 'FSav4', 'FSav5', 'LoanBalance', 'StartSched',
        'FunderCode', 'PrgCode', 'LocCode', 'FCOCode', 'GracePeriod', 'GracePrd', 'PrinMOP', 'TermQty',
        'TermTime', 'MOP', 'IRate', 'IntMOP', 'IntComp', 'TermRes', 'PrinBal', 'IntBal', 'SavBal',
        'TransCodeOR', 'TransCodeJV', 'ClosedDate', 'RestructuredFrom', 'PymtTypeSav1', 'PymtTypeSav2',
        'PymtTypeSav3', 'PymtTypeSav4', 'PymtTypeSav5', 'PymtAmtSav1', 'PymtAmtSav2', 'PymtAmtSav3',
        'PymtAmtSav4', 'PymtAmtSav5', 'LoanProceeds', 'PymtMode1', 'PymtMode2', 'PymtMode3', 'PymtMode4',
        'PymtMode5', 'LoanNumber', 'CenterGrpKey'
    ];

    public function clientele()
    {
        return $this->belongsTo(Clientele::class, 'ClientCode', 'ClientCode');
    }

    public function loanApplication()
    {
        return $this->belongsTo(LoanApplication::class, 'LACode', 'LACode');
    }
}
