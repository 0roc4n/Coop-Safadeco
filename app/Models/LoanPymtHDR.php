<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanPymtHDR extends Model
{
    public $timestamps = false;

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
