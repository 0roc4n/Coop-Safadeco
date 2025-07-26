<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CostCenterDtl extends Model
{
    protected $table = 'costcenterdtl';
    protected $fillable = [
        'CostCenterCode',
        'AcctCode',
    ];
}
