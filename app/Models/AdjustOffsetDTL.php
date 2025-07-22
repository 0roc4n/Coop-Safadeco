<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdjustOffsetDTL extends Model
{
    protected $fillable = [
        'TranNo',
        'SavingsCode',
        'BalanceAmt',
        'OffsetAmt',
    ];

    public function adjustOffsetHDR()
    {
        return $this->belongsTo(AdjustOffsetHDR::class, 'TranNo', 'TranNo');
    }
}
