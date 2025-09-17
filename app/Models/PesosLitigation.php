<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesosLitigation extends Model
{
    protected $table = 'pesoslitigation';


    protected $fillable = [
        'AsOfDate',
        'Amount',
    ];
}
