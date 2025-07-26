<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CasaDebitCreditMemoFile extends Model
{
    protected $table = 'casadebitcreditmemofiles';

    protected $fillable = [
        'MasterID',
        'pdir',
        'pfileName',
        'datecreated',
        'MemoType',
    ];

    public function master()
    {
        return $this->belongsTo(CasaDebitCreditMemoMaster::class, 'MasterID', 'ID');
    }
}
