<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChartOfAccountsMapOut extends Model
{
    protected $fillable = [
        'AcctCode',
        'BOSAccountCode',
    ];

    public function acctCode()
    {
        return $this->belongsTo(AcctCode::class, 'AcctCode', 'AcctCode');
    }
}
