<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bussoperation extends Model
{
    use HasFactory;
    protected $table = 'bussoperations';
    protected $primaryKey = 'BussOpID';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'BussOpCode',
        'BussOpName',
        'Remarks',
        'IsDefault',
    ];

    // Define attributes that should be cast to native types
    protected $casts = [
        'IsDefault' => 'boolean', // Assuming tinyint(1) means boolean
    ];
}
