<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectorLoc extends Model
{
    protected $table = 'collectorsloc';

    protected $fillable = [
        'CollectorID',
        'SubLocID',
        'StartDate',
        'EndDate',
        'IsActive',
    ];
}
