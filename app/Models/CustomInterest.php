<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomInterest extends Model
{
    protected $table = 'custominterest';
    protected $primaryKey = 'LoanCode';


    protected $fillable = [
        'LoanCode',
        'UpfrontInt',
        'UpfrontTerm',
        'AmortInt',
        'AmortTerm',
        'LumpSumInt',
        'LumpSumTerm',
        'UsePrincipal',
        'PrinModeOfComp',
        'UpfrontComp',
        'AmortComp',
        'LumpsumComp',
        'PymtFrequency',
    ];
}
