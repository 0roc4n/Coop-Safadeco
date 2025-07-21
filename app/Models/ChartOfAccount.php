<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    use HasFactory;

    protected $table = 'chartofaccounts';
    protected $primaryKey = 'AcctCode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'AcctCode',
        'AcctName',
        'AcctType',
        'IsActive',
    ];

    protected $casts = [
        'IsActive' => 'boolean',
    ];
}
