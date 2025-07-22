<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OldLoanPymtHDR extends Model
{
    protected $fillable = [
        'TransCode',
        'CLKey',
        'PymtDate',
        'RefNum',
        'Remarks',
        'ORnum',
        'TransType',
        'FolderKey',
    ];

    public function clientLoan(): BelongsTo
    {
        return $this->belongsTo(ClientLoan::class, 'CLKey', 'CLKey');
    }
}
