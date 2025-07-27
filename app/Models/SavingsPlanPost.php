<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavingsPlanPost extends Model
{
    protected $table = 'savingsplanpost';
    protected $primaryKey = 'SPPostID';

    protected $fillable = [
        'ClSavID', 'Amount', 'PostDate',
        'isExtend', 'isBegRateBal', 'Transcode'
    ];
}
