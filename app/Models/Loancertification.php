<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loancertification extends Model
{
    protected $table = 'loancertification';

    public $timestamps = false;

    protected $fillable = [
        'Minimum',
        'Maximum',
        'Remarks',
        'Active',
    ];
}
