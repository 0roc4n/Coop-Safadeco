<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;
    protected $fillable = [
        'AcctCode',
        'BranchName',
        'BankAcctNo',
        'Address',
        'TelNo',
        'FaxNo',
        'MobileNo',
        'Contact',
        'Department',
        'Position',
        'CheckFormat',
        'BankName',
    ];

    public function acctCode()
    {
        return $this->belongsTo(AcctCode::class, 'AcctCode', 'AcctCode');
    }
}
