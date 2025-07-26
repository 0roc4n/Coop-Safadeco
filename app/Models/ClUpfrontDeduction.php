<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClUpfrontDeduction extends Model
{
    protected $table = 'clupfrontdeductions';

    protected $fillable = [
        'CLKey',
        'AcctCode',
        'PymtType',
        'PymtValue',
        'ExcludeInLoanProceeds',
        'UpfrontBasis',
    ];
}
