<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaDisposed extends Model {
    protected $table = 'fadisposed';
    protected $primaryKey = 'FADKey';

    protected $fillable = [
        'TransCode', 'TranDate', 'ItemKey', 'NetBookAmt',
        'LossAmt', 'GainAmt', 'Remarks', 'StatusCode',
        'UserRefCd', 'Cash', 'FolderKey',
    ];
}
