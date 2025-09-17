<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GaAttendanceHeader extends Model
{
    protected $table = 'gaattendanceheader';
    protected $primaryKey = 'AutoID';

    protected $fillable = [
        'Date',
        'Year',
        'Venue',
        'Theme',
        'Posted',
    ];
}
