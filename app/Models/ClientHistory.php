<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientHistory extends Model
{
    use HasFactory;

    protected $primaryKey = 'HistoryID';

    protected $fillable = [
        'ClientCode',
        'OfficeCode',
        'Remarks',
        'FromDate',
        'ToDate',
    ];

    public function clientele()
    {
        return $this->belongsTo(Clientele::class, 'ClientCode', 'ClientCode');
    }
}
