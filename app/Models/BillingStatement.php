<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillingStatement extends Model
{
    protected $table = 'billingstatement';
    protected $primaryKey = 'BillID';
    public $timestamps = false;

    protected $fillable = [
        'AcctCode',
        'ClientCode',
        'AmtDue',
        'AmtPaid',
        'BillHdrID',
        'BillType',
        'TransCode',
    ];

    public function header()
    {
        return $this->belongsTo(BillingStatementHdr::class, 'BillHdrID', 'BillingHdrID');
    }

    public function loanEntries()
    {
        return $this->hasMany(BillingLoan::class, 'BillID', 'BillID');
    }

    public function savingsEntries()
    {
        return $this->hasMany(BillingSaving::class, 'BillID', 'BillID');
    }
}
