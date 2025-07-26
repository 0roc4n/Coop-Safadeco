<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankCharge extends Model
{
    protected $table = 'charge_transactions';

    protected $fillable = [
        'ChargeType',
        'TransCode',
        'ClientCode',
        'SavingsCode',
        'Passbook',
        'Period',
        'Amount',
        'Except_yn',
        'PostingDate',
        'Remarks',
        'FolderKey',
        'AmtPaid',
    ];
}
