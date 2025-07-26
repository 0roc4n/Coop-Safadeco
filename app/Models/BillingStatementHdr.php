<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillingStatementHdr extends Model
{
    protected $table = 'billingstatementhdr';
    protected $primaryKey = 'BillingHdrID';
    public $timestamps = false;

    protected $fillable = [
        'BillingDate',
        'DocumentNo',
        'Remarks',
        'PymtDate',
        'DateGenerated',
        'TransCode',
    ];

    public function billingStatements()
    {
        return $this->hasMany(BillingStatement::class, 'BillHdrID', 'BillingHdrID');
    }
}
