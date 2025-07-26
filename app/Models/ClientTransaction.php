<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientTransaction extends Model
{
    protected $table = 'client_transactions';

    protected $fillable = [
        'ClientCode',
        'AcctCode',
        'AcctTitle',
        'Debit',
        'Credit',
        'DateOfTran',
        'TransCode',
        'FolderKey',
        'Posted',
        'DatePosted',
        'UserID',
        'TransRef',
        'Journal',
        'FunderCode',
        'PrgCode',
        'LocCode',
        'FCOCode',
        'ChkNumber',
        'FATranNo',
    ];

    // Optional relationships
    public function client()
    {
        return $this->belongsTo(Client::class, 'ClientCode', 'ClientCode');
    }

    public function account()
    {
        return $this->belongsTo(AcctCode::class, 'AcctCode', 'AcctCode');
    }

    public function trans()
    {
        return $this->belongsTo(TransCode::class, 'TransCode', 'TransCode');
    }
}
