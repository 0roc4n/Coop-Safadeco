<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcctInitBal extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'AcctCode',
        'BegDate',
        'BegBal',
        'BalUpdated',
    ];

    public function acctCode()
    {
        return $this->belongsTo(AcctCode::class, 'AcctCode', 'AcctCode');
    }
}
