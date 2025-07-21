<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Check extends Model
{
    use HasFactory;

    protected $table = 'checks';
    protected $primaryKey = 'CheckID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'AcctCode',
        'TransCode',
        'Amount',
        'Payee',
        'Description',
        'CheckNo',
        'CheckDate',
        'IsCleared',
        'Remarks',
        'DateEncoded',
    ];

    protected $casts = [
        'Amount' => 'decimal:4',
        'CheckDate' => 'datetime',
        'IsCleared' => 'boolean',
        'DateEncoded' => 'datetime',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(ChartOfAccount::class, 'AcctCode', 'AcctCode');
    }

    public function transactionOperation(): BelongsTo
    {
        return $this->belongsTo(BussOperation::class, 'TransCode', 'BussOpCode');
    }
}
