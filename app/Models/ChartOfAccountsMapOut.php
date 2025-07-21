<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChartOfAccountsMapOut extends Model
{
    use HasFactory;

    protected $table = 'chartofaccountsmapout';
    protected $primaryKey = 'MapID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'AcctCode',
        'BOSAccountCode',
        'DateEncoded',
    ];

    protected $casts = [
        'DateEncoded' => 'datetime',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(ChartOfAccount::class, 'AcctCode', 'AcctCode');
    }

    // If BOSAccountCode references another system's account table, you would add a relationship here.
}
