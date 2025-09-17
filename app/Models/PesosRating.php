<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesosRating extends Model
{
    protected $table = 'pesosrating';


    protected $fillable = [
        'Category',
        'PercentFrom',
        'PercentTo',
        'Range',
        'Equivalent',
        'Condition',
        'Description',
    ];
}
