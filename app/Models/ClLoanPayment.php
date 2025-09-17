<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClLoanPayment extends Model
{
    protected $table = 'clloanpayments';

    protected $fillable = [
        'CLKey',
        'PCLKey',
        'PrincipalAmt',
        'InterestAmt',
    ];

    public function clientLoan()
    {
        return $this->belongsTo(ClientLoan::class, 'CLKey', 'CLKey');
    }

    public function parentLoan()
    {
        return $this->belongsTo(ClientLoan::class, 'PCLKey', 'CLKey');
    }
}
