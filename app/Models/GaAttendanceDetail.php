<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GaAttendanceDetail extends Model
{
    protected $table = 'gaattendancedetail';
    protected $primaryKey = 'AutoID';


    protected $fillable = [
        'ClientCode',
        'ClientName',
        'NickName',
        'ID',
    ];
}
