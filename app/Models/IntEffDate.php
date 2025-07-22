<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntEffDate extends Model
{
    use HasFactory;
    protected $primaryKey = 'IntEffDateID';

    protected $fillable = [
        'Date',
        'AcctCode',
    ];

    public function acctCode()
    {
        return $this->belongsTo(AcctCode::class, 'AcctCode', 'AcctCode');
    }
}
