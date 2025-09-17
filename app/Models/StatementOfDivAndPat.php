<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatementOfDivAndPat extends Model
{
    protected $table = 'statementofdivandpat';

    protected $primaryKey = 'AutoID';

    protected $fillable = [
        'AmountAllocated',
        'TotalAverageShare',
        'CutOff',
        'StartDate',
        'EndDate',
        'TransDiv',
        'AcctCode',
    ];
}
