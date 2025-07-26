<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaAssetHdr extends Model {
    protected $table = 'fassethdr';
    protected $primaryKey = 'TranNo';
    public $timestamps = false;

    protected $fillable = [
        'TransCode', 'AcctCode', 'StatusCode', 'FolderKey',
    ];
}
