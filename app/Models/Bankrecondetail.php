<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bankrecondetail extends Model
{
    protected $primaryKey = 'BankDetailID';
    public $timestamps = false;

    protected $fillable = [
        'BankReconID',
        'TransCode',
        'CheckID',
    ];

    public function reconciliation()
    {
        return $this->belongsTo(BankReconciliation::class, 'BankReconID', 'BankReconID');
    }

    public function check()
    {
        return $this->belongsTo(Check::class, 'CheckID', 'CheckID');
    }
}
