<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GaAllocationDetail extends Model
{
    protected $table = 'gaallocationdetail';
    protected $primaryKey = 'AutoID';

    protected $fillable = [
        'ClientCode',
        'ClientName',
        'AcctCode',
        'Description',
        'Balance',
        'FolderKey',
        'Deduction',
        'RemainingBalance',
        'ID',
        'Type',
        'TransCode',
        'CheckNo',
        'MemberType',
    ];
}
