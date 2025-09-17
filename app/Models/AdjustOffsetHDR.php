<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdjustOffsetHDR extends Model
{
    protected $primaryKey = 'TranNo';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'ClientCode',
        'AcctCode',
        'JVNo',
        'AdjDate',
        'AdjustedAmt',
        'OffsetAmt',
        'PrincipalBalAmt',
        'PrincipalPaidAmt',
        'InterestBalAmt',
        'InterestPaidAmt',
        'CSav1BalAmt',
        'CSav1PaidAmt',
        'CSav2BalAmt',
        'CSav2PaidAmt',
        'CSav3BalAmt',
        'CSav3PaidAmt',
        'CSav4BalAmt',
        'CSav4PaidAmt',
        'CSav5BalAmt',
        'CSav5PaidAmt',
        'PenaltyBalAmt',
        'PenaltyPaidAmt',
        'ISCloseLoan',
        'CLKey',
        'FolderKey',
        'Remarks',
        'StatusCode',
    ];

    public function acctCode()
    {
        return $this->belongsTo(AcctCode::class, 'AcctCode', 'AcctCode');
    }

    public function clientele()
    {
        return $this->belongsTo(Clientele::class, 'ClientCode', 'ClientCode');
    }

    public function clientLoan()
    {
        return $this->belongsTo(ClientLoan::class, 'CLKey', 'CLKey');
    }
}
