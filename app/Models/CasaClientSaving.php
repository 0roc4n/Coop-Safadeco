<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CasaClientSaving extends Model
{
    protected $table = 'casaclientsavings';

    protected $fillable = [
        'BranchCode',
        'GroupCode',
        'AccountNumber',
        'ClientCode',
        'SavingsCode',
        'CSHDRKey',
        'AccountName',
    ];
}
