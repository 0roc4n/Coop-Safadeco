<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProtherCollectible extends Model
{
    protected $table = 'prothercollectibles';

    protected $fillable = [
        'CollectibleCode',
        'Description',
        'Acctcode',
        'Amount',
    ];
}
