<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientSavingsPlan extends Model
{
    protected $table = 'clientsavingsplan';
    protected $primaryKey = 'ClSavID';
    public $timestamps = false;

    protected $fillable = [
        'PolicyID',
        'ClientCode',
        'AppDate',
        'StartDate',
        'StatusCode',
        'IsExtended',
        'UserID',
        'PolUnits',
        'Transcode',
        'StartWaitPeriod',
        'MaturityDate',
        'InterestBal',
        'StartExtPeriod',
        'ExtMaturityDate',
        'XTranscode',
        'TerminateDate',
    ];
}
