<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientSavingsDtl extends Model
{
    protected $table = 'clientsavingsdtl';
    protected $primaryKey = 'ID';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'ID',
        'RefNo',
        'CSHDRKey',
        'TransNo',
        'TransDate',
        'Amount',
        'Remarks',
        'Type',
        'TransType',
        'Teller',
        'Workstation',
        'PrnSlipYN',
        'PrnPassbookYN',
        'PrnLedgerYN',
        'Status',
        'Batch',
        'Time',
        'TransDesc',
        'Line',
        'Page',
        'Book',
        'CashAccnt',
        'LineLedger',
        'PageLedger',
    ];
}
