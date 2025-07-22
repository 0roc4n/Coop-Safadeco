<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcctSummary extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'BranchCode',
        'AcctCode',
        'Type',
        'DateProcessed',
        'Amount',
        'FolderKey',
    ];

    public function acctCode()
    {
        return $this->belongsTo(AcctCode::class, 'AcctCode', 'AcctCode');
    }
}
