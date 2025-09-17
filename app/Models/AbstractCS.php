<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbstractCS extends Model
{
    protected $table = 'abstract_c_s';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'Col_no',
        'AcctCode',
        'Description',
        'Title',
    ];

    public function acctCode()
    {
        return $this->belongsTo(AcctCode::class, 'AcctCode', 'AcctCode');
    }
}
