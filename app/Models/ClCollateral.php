<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClCollateral extends Model
{
    use HasFactory;

    protected $table = 'clcollateral';
    protected $primaryKey = 'CollatID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'CLKey',
        'Collateral',
        'Amount',
        'Remarks',
        'EncodedBy',
        'DateEncoded',
    ];

    protected $casts = [
        'Amount' => 'decimal:4',
        'DateEncoded' => 'datetime',
    ];

    public function loan(): BelongsTo
    {
        return $this->belongsTo(ClientLoan::class, 'CLKey', 'CLKey');
    }
}
