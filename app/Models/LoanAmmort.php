<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanAmmort extends Model
{
    protected $fillable = [
        'CLKey',
        'DateDue',
        'Principal',
        'Interest',
        'FSav1',
        'FSav2',
        'FSav3',
        'FSav4',
        'FSav5',
        'Balance',
        'Arrears',
        'AmtPaid',
        'TransCode',
        'LastPymt',
        'CmtPymt',
        'SCharge',
        'PenaltyAmt',
    ];

    public function clientLoan()
    {
        return $this->belongsTo(ClientLoan::class, 'CLKey', 'CLKey');
    }
}
