<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loantranspymt extends Model
{
    protected $table = 'loantranspymt';

    protected $fillable = [
        'PymtDate', 'PymtType', 'PymtCode', 'TransCode', 'ClientCode', 'Amount',
        'CheckNumber', 'ColDate', 'CashAmount', 'CheckAmount', 'FolderKey', 'StatusCode',
        'Remarks', 'ModuleType', 'DebitAcct', 'DebitSL'
    ];
}
