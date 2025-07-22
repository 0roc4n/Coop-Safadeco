<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OldCLCollateral extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'CLKey',
        'Collateral',
        'Value',
    ];

    // Relationship to ClientLoan
    public function clientLoan(): BelongsTo
    {
        return $this->belongsTo(ClientLoans::class, 'CLKey', 'CLKey');
    }
}
