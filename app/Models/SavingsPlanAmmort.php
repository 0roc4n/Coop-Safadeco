<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavingsPlanAmmort extends Model
{
    protected $table = 'savingsplanammort';
    protected $primaryKey = 'SavAmID';


    protected $fillable = [
        'ClSavID', 'DueDate', 'Principal', 'PrinBal', 
        'AmountPaid', 'PaidBal', 'DatePaid'
    ];
}
