<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    protected $primaryKey = 'CenterCode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'CenterCode',
        'DateFormed',
        'Description',
        'Location',
        'Rank1',
        'Rank2',
        'Rank3',
        'FOfficer1',
        'FOfficer2',
    ];
}
