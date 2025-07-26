<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collector extends Model
{
    protected $table = 'collectors';
    protected $primaryKey = 'CollectorID';

    protected $fillable = [
        'CollectorID',
        'ClientCode',
        'Remarks',
    ];
}
