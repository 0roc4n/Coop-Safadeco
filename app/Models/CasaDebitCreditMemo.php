<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CasaDebitCreditMemo extends Model
{
    protected $table = 'casadebitcreditmemo';

    protected $fillable = [
        'MasterID',
        'TransDate',
        'BranchCode',
        'GroupCode',
        'AccountNumber',
        'Debit',
        'Credit',
        'Mnemonic',
        'TransCode',
        'ClientCode',
        'AcctCode',
        'LookUpKey',
        'Remarks',
        'Validate',
    ];

    public function master()
    {
        return $this->belongsTo(CasaDebitCreditMemoMaster::class, 'MasterID', 'ID');
    }
}
