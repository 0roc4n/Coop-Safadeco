<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanCASAInterfaceParameters extends Model
{
    protected $fillable = [
        'dirpathdmcm',
        'dirpathticket',
        'BranchCode',
        'CentralServer',
        'CASADB',
        'AccountingDB',
        'DefaultCASAUser',
        'CIFDB',
        'CentralLoanServer',
        'CASALoanDB',
        'AcctgLoanDB',
        'UploadModeTickets',
        'UploadModeMemos',
        'URLTicketUpload',
        'URLMemoUpload',
    ];
}
