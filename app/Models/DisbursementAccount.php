<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisbursementAccount extends Model
{
    protected $table = 'disbursementaccounts';

    protected $fillable = [
        'LoanCode',
        'AcctCode',
        'SetAsDefault',
    ];
}
