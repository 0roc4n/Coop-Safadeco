<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mappayrollcode extends Model
{
    protected $table = 'mappayrollcode';

    protected $fillable = [
        'UploadID',
        'AcctCode',
        'PCode',
    ];
}
