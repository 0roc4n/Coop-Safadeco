<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prtimedeposit extends Model
{
    protected $table = 'prtimedeposits';

    protected $fillable = [
        'AcctCode', 'Description', 'AccruedInterest', 'nonWorkingDays',
        'TimeDepInt', 'TimeDepIntAcct', 'AccruedIntAcct', 'WTaxInt',
        'WTaxAcct', 'AccruedWTaxAcct', 'WithholdingTax'
    ];
}
