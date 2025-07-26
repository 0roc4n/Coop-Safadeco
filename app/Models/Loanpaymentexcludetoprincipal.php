<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loanpaymentexcludetoprincipal extends Model
{
    protected $table = 'loanpaymentexcludetoprincipal';

    protected $fillable = [
        'clkey',
        'loannumber',
        'isexcluded',
    ];
}
