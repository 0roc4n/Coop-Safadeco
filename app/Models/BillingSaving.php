<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillingSaving extends Model
{
    protected $table = 'billingsavings';
    protected $primaryKey = 'BillSavingsID';
    public $timestamps = false;

    protected $fillable = [
        'CSHDRKey',
        'BillID',
    ];

    public function billingStatement()
    {
        return $this->belongsTo(BillingStatement::class, 'BillID', 'BillID');
    }
}
