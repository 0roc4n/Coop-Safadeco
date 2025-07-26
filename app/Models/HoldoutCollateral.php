<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HoldoutCollateral extends Model
{
    protected $table = 'holdoutcollateral';

    protected $fillable = [
        'ColID',
        'HoldOutID',
    ];
}
