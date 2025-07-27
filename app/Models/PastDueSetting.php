<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PastDueSetting extends Model
{
    protected $table = 'past_due_settings';

    protected $primaryKey = 'ID';

    public $timestamps = false;

    protected $fillable = [
        'Description',
        'DTParam',
        'IntPDI',
        'DTType',
        'GrpName',
        'Remarks',
        'ReportID',
    ];
}
