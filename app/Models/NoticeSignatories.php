<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoticeSignatories extends Model
{
    protected $table = 'notice_signatories';
    protected $fillable = [
        'Nottype',
        'Nname',
        'Nposition',
        'Cname',
        'Cposition',
    ];
}
