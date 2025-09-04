<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoanApplications extends Model
{
    use HasFactory;

    protected $primaryKey = 'LACode';
    public $incrementing = true;

    protected $fillable = [
        'DtOfApp',
        'ClientCode',
        'Approved',
        'UserApproved',
        'ApproveDate',
        'UserRefCd',
        'LoanTotalPaid',
        'Remarks',
        'RatingScore',
        'LoanNumber',
        'LoanType',
        'LoanStatus',
        'AppRemarks',
    ];

    public function clientele()
    {
        return $this->belongsTo(Clientele::class, 'ClientCode', 'ClientCode');
    }
}
