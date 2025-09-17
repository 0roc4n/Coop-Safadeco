<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Noticesetup extends Model
{
    protected $table = 'noticesetup';
    protected $primaryKey = 'NSupID';

    protected $fillable = [
        'NotType',
        'Descs',
        'NumDays',
        'MatDays',
        'Remarks',
    ];
}
