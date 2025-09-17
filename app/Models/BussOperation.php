<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BussOperation extends Model
{
    protected $primaryKey = 'BussOpID';
    public $incrementing = false; // Change to true if auto-incrementing
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'BussOpID',
        'BussOpCode',
        'BussOpName',
        'Remarks',
        'IsDefault',
    ];
}
