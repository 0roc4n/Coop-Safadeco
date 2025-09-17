<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthEnd extends Model
{
    protected $primaryKey = 'MonthEndID';
    public $incrementing = false;

    protected $fillable = [
        'MonthEndID',
        'MonthEndDate',
    ];
}
