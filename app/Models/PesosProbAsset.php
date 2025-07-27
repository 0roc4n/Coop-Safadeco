<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesosProbAsset extends Model
{
    protected $table = 'pesosprobassets';

    protected $fillable = [
        'AsOfDate',
        'Amount',
    ];
}
