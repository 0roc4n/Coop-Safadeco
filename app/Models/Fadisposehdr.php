<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaDisposeHdr extends Model {
    protected $table = 'fadisposehdr';


    protected $fillable = [
        'DateOfDisposal', 'TotalGain', 'TotalLoss',
        'Status', 'Remarks', 'FolderKey', 'TotalCost',
    ];
}
