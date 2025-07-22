<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcctCode extends Model
{
    protected $table = 'acct_codes';
    protected $primaryKey = 'AcctCode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'AcctCode',
        'Type',
        'SubType',
        'Description',
        'AcctType',
        'HasSL',
        'RelatedParentCode',
        'CodeExt',
        'XOverride',
        'AcctClass',
        'AccumDepCode',
        'CashFlowType',
        'IsExpAnalysis',
        'isFinance',
    ];

}
