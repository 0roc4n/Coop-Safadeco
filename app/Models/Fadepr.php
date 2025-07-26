<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaDepr extends Model {
    protected $table = 'fadepr';
    protected $primaryKey = 'FAKey';

    protected $fillable = [
        'FolderKey', 'PostingDate', 'TransCode', 'TranDate', 'TotalAmt',
        'Remarks', 'StatusCode', 'UserRefCD',
    ];
}
