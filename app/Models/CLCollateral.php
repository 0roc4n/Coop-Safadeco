<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CLCollateral extends Model
{
    protected $table = 'cl_collateral';

    protected $primaryKey = 'ColID';

    public $timestamps = false;

    protected $fillable = [
        'CLKey',
        'Collateral',
        'Value',
    ];

    // Relationship
    public function clientLoan(): BelongsTo
    {
        return $this->belongsTo(ClientLoan::class, 'CLKey', 'CLKey');
    }
}
