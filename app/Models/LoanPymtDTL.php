<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanPymtDTL extends Model
{
    protected $primaryKey = 'LoanPymtKey';

    protected $fillable = [
        'CLKey', 'PaymentDate', 'Principal', 'Interest', 'Penalty',
        'FSav1', 'FSav2', 'FSav3', 'FSav4', 'FSav5', 'TotalPayment',
        'TransCode', 'ORNum', 'Remarks', 'FolderKey',
        'BalPrin', 'BalInt', 'BalPen',
        'BalSav1', 'BalSav2', 'BalSav3', 'BalSav4', 'BalSav5',
        'IsPaidByAdjust', 'PaidBy'
    ];

    public function clientLoan()
    {
        return $this->belongsTo(ClientLoan::class, 'CLKey', 'CLKey');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'FolderKey', 'FolderKey');
    }
}
