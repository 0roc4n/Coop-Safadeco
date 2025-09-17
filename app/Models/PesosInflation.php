<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesosInflation extends Model
{
    protected $table = 'pesosinflation';


    protected $fillable = [
        'InflationYear',
        'InflationMonth',
        'InflationRate',
    ];
}
