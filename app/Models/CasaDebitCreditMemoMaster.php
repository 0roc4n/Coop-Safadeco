<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CasaDebitCreditMemoMaster extends Model
{
    protected $table = 'casadebitcreditmemomaster';
    public $timestamps = false;

    protected $fillable = [
        'TransDate',
        'DatePosted',
        'Mnemonic',
        'Remarks',
        'Posted',
        'BatchFileName',
        'CreatedBy',
        'UploadedBy',
        'CASAUser',
    ];

    public function memos()
    {
        return $this->hasMany(CasaDebitCreditMemo::class, 'MasterID', 'ID');
    }

    public function files()
    {
        return $this->hasMany(CasaDebitCreditMemoFile::class, 'MasterID', 'ID');
    }
}
