<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skippedday extends Model
{
    protected $table = 'skippeddays';
    // protected $primaryKey = 'ID';

    protected $fillable = ['DayOfWeek'];
}
