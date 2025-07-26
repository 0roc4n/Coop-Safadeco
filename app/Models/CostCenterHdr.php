<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CostCenterHdr extends Model
{
    protected $table = 'costcenterhdr';
    protected $primaryKey = 'CostCenterCode';

    protected $fillable = [
        'CostCenterCode',
        'Description',
        'Remarks',
        'Tag',
    ];
}
