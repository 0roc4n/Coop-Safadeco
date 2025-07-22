<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcctCodesJournal extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'AcctCode',
        'IsCR',
        'IsCD',
        'IsNC',
    ];

    public function acctCode()
    {
        return $this->belongsTo(AcctCode::class, 'AcctCode', 'AcctCode');
    }
}
