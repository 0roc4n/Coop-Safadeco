<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CasaDebitCreditMemo extends Model
{
    use HasFactory;

    protected $table = 'casadebitcreditmemo';
    protected $primaryKey = 'DCID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'MasterID',
        'ClientCode',
        'AcctCode',
        'Amount',
        'DC',
        'DateEncoded',
        'IsConfirm',
        'ConfirmationNumber',
        'Reference',
        'Remarks',
        'TransDate',
    ];

    protected $casts = [
        'Amount' => 'decimal:4',
        'DateEncoded' => 'datetime',
        'IsConfirm' => 'boolean',
        'TransDate' => 'datetime',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Clientele::class, 'ClientCode', 'ClientCode');
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(ChartOfAccount::class, 'AcctCode', 'AcctCode');
    }

    // If MasterID references a header table, you would add a relationship here.
    // public function masterTransaction(): BelongsTo
    // {
    //     return $this->belongsTo(MasterTransaction::class, 'MasterID', 'id');
    // }
}
