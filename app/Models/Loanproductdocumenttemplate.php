<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loanproductdocumenttemplate extends Model
{
    protected $table = 'loanproductdocumenttemplate';

    protected $fillable = [
        'ReportDir',
        'ReportFile',
        'AcctCode',
    ];
}
