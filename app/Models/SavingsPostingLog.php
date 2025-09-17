<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavingsPostingLog extends Model
{
    protected $table = 'savingspostinglog';
    protected $primaryKey = 'PostingID';

    protected $fillable = [
        'FolderKey', 'PostingDate', 'AcctCode',
        'PostingType', 'PeriodType', 'TransCode'
    ];
}
