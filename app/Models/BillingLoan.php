<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillingLoan extends Model
{
    protected $table = 'billingloans';
    protected $primaryKey = 'BillLoanID';
    public $timestamps = false;

    protected $fillable = [
        'CLKey',
        'LoanPymtType',
        'BillID',
    ];

    public function billingStatement()
    {
        return $this->belongsTo(BillingStatement::class, 'BillID', 'BillID');
    }
}

