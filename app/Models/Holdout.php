<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Holdout extends Model
{
    protected $table = 'holdout';
    protected $primaryKey = 'HoldOutID';

    protected $fillable = [
        'CSHDRKey',
        'ID',
        'AccountCode',
        'Amount',
        'StartDate',
        'EndDate',
        'DateOfTran',
        'Period',
        'Unit',
        'Remarks',
        'Tag',
    ];
}
