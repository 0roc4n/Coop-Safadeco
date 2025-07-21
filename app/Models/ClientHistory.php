<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientHistory extends Model
{
    use HasFactory;

    protected $table = 'client_histories';
    protected $primaryKey = 'HistoryID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'ClientCode',
        'OfficeCode',
        'Remarks',
        'FromDate',
        'ToDate',
    ];

    protected $casts = [
        'FromDate' => 'datetime',
        'ToDate' => 'datetime',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Clientele::class, 'ClientCode', 'ClientCode');
    }

    // If you have an 'Office' model for 'offices' table, you would add a relationship like this:
    // public function office(): BelongsTo
    // {
    //     return $this->belongsTo(Office::class, 'OfficeCode', 'OfficeCode');
    // }
}
