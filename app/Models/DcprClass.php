<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DcprClass extends Model
{
    protected $table = 'dcprclass';
    public $timestamps = false;

    protected $fillable = [
        'ClassID',
        'ClassName',
        'Type',
    ];
}
