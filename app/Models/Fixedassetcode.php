<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fixedassetcode extends Model
{
    protected $table = 'fixedassetcodes';
    public $timestamps = false;

    protected $fillable = [
        'AcctCode',
        'AccumDepCode',
        'DepExpense',
    ];
}
