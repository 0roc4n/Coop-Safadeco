<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SlBalance extends Model
{

    protected $fillable = [
        'FolderKey',
        'Mnth',
        'AcctCode',
        'ClientCode',
        'Balance',
    ];
}
