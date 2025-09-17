<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dcpr extends Model
{
    protected $table = 'dcpr';
    protected $primaryKey = 'DCPRID';

    protected $fillable = [
        'DCPRID',
        'ClassID',
        'AcctCode',
    ];
}
