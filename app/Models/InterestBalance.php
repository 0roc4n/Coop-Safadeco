<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterestBalance extends Model
{
    protected $fillable = [
        'LoanPymtKey',
        'CLKey',
        'Pymtdate',
        'AmtDue',
        'AmtPaid',
        'Balance',
    ];

    public function loanPayment(): BelongsTo
    {
        return $this->belongsTo(LoanPymtDTL::class, 'LoanPymtKey', 'LoanPymtKey');
    }

    public function clientLoan(): BelongsTo
    {
        return $this->belongsTo(ClientLoan::class, 'CLKey', 'CLKey');
    }
}
