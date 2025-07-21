<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientComaker extends Model
{
    use HasFactory;

    protected $table = 'client_comakers';
    protected $primaryKey = 'CoMakeID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'CLKey',
        'ClientCode',
        'Remarks',
        'DateEncoded',
    ];

    protected $casts = [
        'DateEncoded' => 'datetime',
    ];

    public function loan(): BelongsTo
    {
        return $this->belongsTo(ClientLoan::class, 'CLKey', 'CLKey');
    }

    public function comakerClient(): BelongsTo
    {
        return $this->belongsTo(Clientele::class, 'ClientCode', 'ClientCode');
    }
}
