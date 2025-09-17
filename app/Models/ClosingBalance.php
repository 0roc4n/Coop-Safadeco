<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClosingBalance extends Model
{
    protected $table = 'closingbalance';
    public $incrementing = false;
    public $timestamps = false;

    protected $primaryKey = null; // Laravel doesn't support composite keys directly

    protected $fillable = [
        'FolderKey',
        'FunderCode',
        'AcctCode',
        'BegBalance',
        'EndBalance',
    ];

    // protected function setKeysForSaveQuery($query)
    // {
    //     return $query->where('FolderKey', $this->FolderKey)
    //                  ->where('AcctCode', $this->AcctCode);
    // }
}
