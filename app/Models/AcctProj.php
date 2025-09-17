<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcctProj extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'BranchCode',
        'AcctCode',
        'InitBalance',
        'JAN', 'ACT_JAN',
        'FEB', 'ACT_FEB',
        'MAR', 'ACT_MAR',
        'APR', 'ACT_APR',
        'MAY', 'ACT_MAY',
        'JUN', 'ACT_JUN',
        'JUL', 'ACT_JUL',
        'AUG', 'ACT_AUG',
        'SEP', 'ACT_SEP',
        'OCT', 'ACT_OCT',
        'NOV', 'ACT_NOV',
        'DEC', 'ACT_DEC',
        'FolderKey',
    ];

    public function acctCode()
    {
        return $this->belongsTo(AcctCode::class, 'AcctCode', 'AcctCode');
    }
}
