<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class CasaClientSaving extends Model
{
    use HasFactory;

    protected $table = 'casaclientsavings';
    protected $primaryKey = 'CSID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'CSHDRKey',
        'ClientCode',
        'Amount',
        'DateEncoded',
        'IsConfirm',
        'ConfirmationNumber',
    ];

    protected $casts = [
        'Amount' => 'decimal:4',
        'DateEncoded' => 'datetime',
        'IsConfirm' => 'boolean',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Clientele::class, 'ClientCode', 'ClientCode');
    }

    // If CSHDRKey references a header table, you would add a relationship like this:
    // public function header(): BelongsTo
    // {
    //     return $this->belongsTo(CasaSavingsHeader::class, 'CSHDRKey', 'id');
    // }
}
