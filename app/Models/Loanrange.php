<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loanrange extends Model
{
    protected $table = 'loanrange';

    protected $fillable = [
        'AcctCode',
        'From',
        'To',
        'Term',
        'Frequency',
        'IRate',
    ];
}
