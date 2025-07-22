<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientCoMaker extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'CLKey',
        'ClientCode',
    ];

    public function clientLoan(): BelongsTo
    {
        return $this->belongsTo(ClientLoan::class, 'CLKey', 'CLKey');
    }

    public function clientele(): BelongsTo
    {
        return $this->belongsTo(Clientele::class, 'ClientCode', 'ClientCode');
    }
}
