<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loantermrate extends Model
{
    protected $table = 'loantermrate';

    protected $fillable = [
        'AcctCode',
        'From',
        'To',
        'IRate',
    ];
}
