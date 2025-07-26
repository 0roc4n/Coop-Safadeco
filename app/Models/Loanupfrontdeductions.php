<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loanupfrontdeductions extends Model
{
    protected $table = 'loanupfrontdeductions';

    protected $fillable = [
        'LoanCode',
        'AcctCode',
        'PymtType',
        'PymtValue',
        'ExcludeInLoanProceeds',
        'UpfrontBasis',
    ];
}
