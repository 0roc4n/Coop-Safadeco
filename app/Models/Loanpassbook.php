<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loanpassbook extends Model
{
    protected $table = 'loanpassbook';

    protected $fillable = [
        'CLKey', 'ClientCode', 'AcctCode', 'TransCode', 'TransDate', 'LoanAmount',
        'PrinAmtPaid', 'IntAmtPaid', 'Penalty', 'Balance', 'PrintPassbook',
        'PrintLedger', 'ModuleType', 'Line', 'Page', 'Book', 'LedgerLine',
        'LedgerPage', 'LedgerBook', 'InterestAmt', 'FSav1Amt', 'FSav2Amt', 'FSav3Amt',
        'FSav4Amt', 'FSav5Amt', 'FSav1Paid', 'FSav2Paid', 'FSav3Paid', 'FSav4Paid', 'FSav5Paid'
    ];
}
