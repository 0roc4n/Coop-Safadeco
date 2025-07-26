<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loanpaymentallocation extends Model
{
    protected $table = 'loanpaymentallocation';

    protected $fillable = [
        'Payment',
        'Description',
        'Priority',
    ];
}
