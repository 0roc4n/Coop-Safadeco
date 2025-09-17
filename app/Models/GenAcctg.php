<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GenAcctg extends Model
{
    use HasFactory;
    protected $table = 'gen_acctgs';

    protected $fillable = [
        'StatusCode',
        'TransCode',
        'DateOfTran',
        'ClientCode',
        'TotalAmt',
        'Remarks',
        'FolderKey',
        'ModuleType',
        'BussOpID',
    ];
}
