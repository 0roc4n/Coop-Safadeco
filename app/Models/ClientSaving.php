<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientSaving extends Model
{
    protected $table = 'clientsavings';
    protected $primaryKey = 'CSHDRKey';
    public $timestamps = false;

    protected $fillable = [
        'ClientCode',
        'Balance',
        'AppDate',
        'Passbook',
        'SavingsCode',
        'Status',
        'DDate',
        'BMaintain',
        'CollectYN',
        'PMode',
        'PAmount',
        'LastPDate',
        'StartCDate',
        'CurrLine',
        'CurrPage',
        'CurrBook',
    ];
}
