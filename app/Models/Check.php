<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Check extends Model
{
    protected $primaryKey = 'CheckID';
    public $timestamps = false;

    protected $fillable = [
        'CheckNo',
        'CheckDate',
        'Amount',
        'TransCode',
        'AcctCode',
    ];

    public function account()
    {
        return $this->belongsTo(AcctCode::class, 'AcctCode', 'AcctCode');
    }
}
