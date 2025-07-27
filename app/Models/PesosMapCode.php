<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesosMapCode extends Model
{
    protected $table = 'pesosmapcodes';


    protected $fillable = [
        'MapType',
        'AcctCode',
        'AcctCodeType',
    ];
}
