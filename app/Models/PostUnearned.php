<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostUnearned extends Model
{

    protected $fillable = [
        'CLKey',
        'Unearned',
        'Earned',
        'Balance',
        'DatePosted',
        'PostingID',
        'TransCode',
        'type',
        'CreditAcct',
    ];
}
