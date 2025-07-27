<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prloaneligibility extends Model
{
    protected $table = 'prloaneligibility';
    public $timestamps = false;

    protected $fillable = [
        'AcctCode', 'MinShareCapital', 'MaxShareCapital', 'Employment',
        'Membership', 'LoanPayment', 'LoanPaymentType', 'RequireCoMaker',
        'TotalCoMakers', 'CoMakerReq', 'FixedDeposits', 'MaxYear'
    ];
}
