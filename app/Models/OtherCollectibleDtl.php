<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtherCollectibleDtl extends Model
{
    protected $table = 'othercollectibledtl';
    protected $primaryKey = 'CollectibleID';

    protected $fillable = [
        'CollectibleID',
        'ClientCode',
        'Collectible',
        'Collected',
        'TransCode',
    ];
}
