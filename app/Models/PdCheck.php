<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PdCheck extends Model
{
    protected $table = 'pd_checks';

    protected $fillable = [
        'LACode',
        'ClientCode',
        'CheckDate',
        'CheckNum',
        'DateDue',
        'LoanCode',
        'Bank',
        'Amount',
        'Funder',
        'Program',
        'Location',
        'TransCode',
    ];
}
