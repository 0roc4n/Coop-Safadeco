<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prfee extends Model
{
    protected $table = 'prfees';

    protected $fillable = [
        'AcctCode', 'Description', 'PymtType', 'Amount',
        'ExCludeInLoanProceeds', 'isFinance', 'isFinanceDesc'
    ];
}
