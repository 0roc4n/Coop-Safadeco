<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loanpurpose extends Model
{
    protected $table = 'loanpurpose';

    protected $fillable = [
        'Code',
        'Description',
        'Remarks',
    ];
}
