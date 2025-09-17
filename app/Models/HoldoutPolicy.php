<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HoldoutPolicy extends Model
{
    protected $table = 'holdoutpolicy';
    protected $primaryKey = 'HoldOutPolicyID';

    protected $fillable = [
        'ID',
        'Description',
        'Period',
        'Unit',
    ];
}
