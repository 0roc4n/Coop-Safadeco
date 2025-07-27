<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenaltyAccountDue extends Model
{
    protected $table = 'penalty_account_dues';


    protected $fillable = [
        'Clkey',
        'LoanPymtkey',
        'Duedate',
        'PreviousDue',
        'AmountDue',
        'AmountPaid',
        'CurrentDue',
        'PostingDate',
        'ActualDueDate',
    ];
}
