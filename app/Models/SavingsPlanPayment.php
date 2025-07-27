<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavingsPlanPayment extends Model
{
    protected $table = 'savingsplanpayment';
    protected $primaryKey = 'SavPymtID';
    public $timestamps = false;

    protected $fillable = [
        'ClSavID', 'Amount', 'PaymentDate', 'TransCode',
        'Remarks', 'FolderKey', 'surcharge', 
        'reinstatementfee', 'iswaive'
    ];
}
