<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reportslog extends Model
{
    protected $table = 'reportslog';

    protected $fillable = [
        'ReportDate',
        'ReportName',
        'ReportType',
        'BeginDate',
        'EndDate',
        'Remarks',
        'UserID',
    ];

    public $timestamps = true;
}
