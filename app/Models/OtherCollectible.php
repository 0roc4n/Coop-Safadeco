<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtherCollectible extends Model
{
    protected $table = 'othercollectible';
    protected $primaryKey = 'CollectibleID';

    protected $fillable = [
        'CollectibleID',
        'CollectionDate',
        'CollectibleCode',
    ];
}
