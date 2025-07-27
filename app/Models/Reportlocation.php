<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reportlocation extends Model
{
    protected $table = 'reportlocations';

    protected $fillable = [
        'ReportID',
        'ReportDir',
        'ReportFile',
    ];
}
