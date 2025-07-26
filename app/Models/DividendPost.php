<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DividendPost extends Model
{
    protected $table = 'dividendpost';

    protected $fillable = [
        'ClientCode',
        'CurBal',
        'AveBal',
        'Dividend',
        'FolderKey',
        'TransCode',
    ];
}
