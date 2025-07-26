<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DormantsAccountsList extends Model
{
    protected $table = 'dormants_accounts_list';

    protected $fillable = [
        'ACCTCODE',
        'SVDESC',
        'CHARGEAMT',
        'CLIENTCODE',
        'LNAME',
        'PASSBOOK',
        'BALANCE',
        'CSHDRKEY',
    ];
}
