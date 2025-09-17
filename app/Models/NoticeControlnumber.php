<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoticeControlnumber extends Model
{
    protected $table = 'notice_controlnumber';
    protected $fillable = [
        'Nottype',
        'ControlNumber',
        'CNumLenght',
        'IsALL',
        'TmpControlNumber',
    ];
}
