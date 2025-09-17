<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavingsPlan extends Model
{
    protected $table = 'savingsplan';
    protected $primaryKey = 'SavID';

    protected $fillable = ['PlanName', 'AcctCode', 'Remark'];

}
