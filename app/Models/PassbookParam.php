<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PassbookParam extends Model
{
    public $timestamps = false;

    protected $table = 'passbookparam';

    protected $fillable = [
        'HeaderHeight',
        'TranDateLeft',
        'DepIntLeft',
        'WithdrawLeft',
        'BalanceLeft',
        'TransDescLeft',
        'DetailHeight',
    ];

}
