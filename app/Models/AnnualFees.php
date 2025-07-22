<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnnualFees extends Model
{
    use HasFactory;

    protected $fillable = [
        'ClientCode',
        'AcctCode',
        'Amount',
        'PymtDate',
        'Year',
    ];

    public function clientele()
    {
        return $this->belongsTo(Clientele::class, 'ClientCode', 'ClientCode');
    }
}
