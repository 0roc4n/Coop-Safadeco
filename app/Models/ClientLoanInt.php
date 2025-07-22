<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientLoanInt extends Model
{
    protected $fillable = [
        'CLKey',
        'IntAfterMaturity_YN',
        'MaturityIntRate',
        'IncIntLOBal_YN',
        'MaturityIntType',
    ];

    public function clientLoan(): BelongsTo
    {
        return $this->belongsTo(ClientLoan::class, 'CLKey', 'CLKey');
    }
}
