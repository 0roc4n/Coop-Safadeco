<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GaAllocationArDeduction extends Model
{
    protected $table = 'gaallocationardeduction';
    protected $primaryKey = 'AutoID';

    protected $fillable = [
        'ClientCode',
        'ClientName',
        'AcctCode',
        'RemainingBalance',
        'Deduction',
        'ID',
    ];
}
