<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DmcmTransactionType extends Model
{
    protected $table = 'dmcmtransactiontypes';

    protected $fillable = [
        'Mnemonic',
        'ModuleTypeID',
        'Description',
        'Module',
    ];
}
