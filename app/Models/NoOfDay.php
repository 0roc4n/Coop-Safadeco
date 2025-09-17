<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoOfDay extends Model
{
    protected $primaryKey = 'NoOfDaysID';

    protected $fillable = [
        'NoOfDays',
        'AcctCode',
        'IntEffDateID',
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
