<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CLCustomInterest extends Model
{
    protected $fillable = [
        'CLKey',
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

    // Relationship to ClientLoan
    public function clientLoan(): BelongsTo
    {
        return $this->belongsTo(ClientLoan::class, 'CLKey', 'CLKey');
    }
}
