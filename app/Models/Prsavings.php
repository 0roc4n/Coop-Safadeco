<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prsavings extends Model
{
    protected $table = 'prsavings';


    protected $fillable = [
        'AcctCode', 'SvDesc', 'SvType', 'PymtMode', 'PymtType', 'PymtVal',
        'IRate', 'UserRefCd', 'Collect_Yn', 'CollPymt', 'CollAmt',
        'MaintainBalance', 'Withdrawable', 'DMonth', 'ChargeAmt',
        'DChargeAmt', 'UpfrontBasis', 'IntExpenseAcct', 'isSpecialSavings', 'sRate'
    ];
}
