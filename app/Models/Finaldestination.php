<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finaldestination extends Model
{
    protected $table = 'finaldestination';
    public $timestamps = false;

    protected $fillable = [
        'Center',
        'LoanedAmt',
        'Outstanding',
        'Period1',
        'Period2',
        'Period3',
        'Period4',
        'Period5',
        'Period6',
        'Period7',
        'Period8',
        'Period9',
        'Period10',
        'Period11',
        'Period12',
        'Period13',
    ];
}
