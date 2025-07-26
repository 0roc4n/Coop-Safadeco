<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClLoanPurpose extends Model
{
    protected $table = 'clloanpurpose';

    protected $fillable = [
        'CLKey',
        'LnPurPoseCode',
    ];

    public function clientLoan()
    {
        return $this->belongsTo(ClientLoan::class, 'CLKey', 'CLKey');
    }
}
