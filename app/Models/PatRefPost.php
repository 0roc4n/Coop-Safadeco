<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatRefPost extends Model
{
    protected $table = 'patrefpost';

    protected $fillable = [
        'ClientCode',
        'AcctCode',
        'CurBal',
        'PatRef',
        'FolderKey',
        'TransCode',
    ];
}
