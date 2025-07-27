<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavingsPlanInterest extends Model
{
    protected $table = 'savingsplaninterest';
    protected $primaryKey = 'SavPlanIntID';


    protected $fillable = [
        'PostDate', 'Amount', 'PostedDate', 'Transcode',
        'IsPosted', 'UserID', 'ClSavID', 'numDays', 
        'SPBal', 'IsExtend'
    ];
}
