<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CertificatesDtl extends Model
{
    use HasFactory;

    protected $table = 'certificates_dtls';
    protected $primaryKey = 'CertDtlID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'ClientCode',
        'CertNumber',
        'FolderKey',
        'Amount',
        'CertDate',
        'Remarks',
    ];

    protected $casts = [
        'Amount' => 'decimal:4',
        'CertDate' => 'datetime',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Clientele::class, 'ClientCode', 'ClientCode');
    }

    public function certificateHeader(): BelongsTo
    {
        return $this->belongsTo(CertificatesHdr::class, 'CertNumber', 'CertNumber');
    }

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'FolderKey', 'FolderKey');
    }
}
