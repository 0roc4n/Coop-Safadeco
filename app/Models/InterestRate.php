<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterestRate extends Model
{
    protected $primaryKey = 'RateID';

    protected $fillable = [
        'From',
        'To',
        'iRate',
        'AcctCode',
        'IntEffDateID',
        'withTax',
    ];

    public function acctCode()
    {
        return $this->belongsTo(AcctCode::class, 'AcctCode', 'AcctCode');
    }

    public function intEffDate()
    {
        return $this->belongsTo(IntEffDate::class, 'IntEffDateID', 'IntEffDateID');
    }
}
