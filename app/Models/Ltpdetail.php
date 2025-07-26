<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ltpdetail extends Model
{
    protected $table = 'ltpdetails';

    protected $fillable = [
        'LoanPymtKey',
        'CLKey',
        'DateDue',
        'PrinAmtPaid',
        'IntAmtPaid',
        'FSav1',
        'FSav2',
        'FSav3',
        'FSav4',
        'FSav5',
    ];
}
