<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClCustomInterest extends Model
{
    use HasFactory;

    protected $table = 'cl_custom_interests';
    protected $primaryKey = 'CIKey';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'CLKey',
        'LoanCode',
        'InterestAmount',
        'Remarks',
        'EncodedDate',
        'EncodedBy',
    ];

    protected $casts = [
        'InterestAmount' => 'decimal:4',
        'EncodedDate' => 'datetime',
    ];

    public function loan(): BelongsTo
    {
        return $this->belongsTo(ClientLoan::class, 'CLKey', 'CLKey');
    }

    // If LoanCode references a LoanProduct model, you'd define it here.
    // public function loanProduct(): BelongsTo
    // {
    //     return $this->belongsTo(LoanProduct::class, 'LoanCode', 'LoanCode');
    // }
}
