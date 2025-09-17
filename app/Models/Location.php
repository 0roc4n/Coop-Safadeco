<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'locations';
    protected $primaryKey = 'loccode';

    protected $fillable = [
        'loccode',
        'locdesc',
        'locremarks',
    ];
}
