<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaDetail extends Model {
    protected $table = 'fadetails';


    protected $fillable = [
        'CoveredDate', 'DepVal', 'AccDep', 'NetBook',
        'Depreciated', 'ItemKey',
    ];
}
