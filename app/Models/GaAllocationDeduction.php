<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GaAllocationDeduction extends Model
{
    protected $table = 'gaallocationdeduction';
    protected $primaryKey = 'AutoID';

    protected $fillable = [
        'ClientCode',
        'ClientName',
        'AcctCode',
        'Amount',
        'ID',
    ];
}
