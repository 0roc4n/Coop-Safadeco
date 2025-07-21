<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CertificatesHdr extends Model
{
    use HasFactory;

    protected $table = 'certificates_hdrs';
    protected $primaryKey = 'CertNumber';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'CertNumber',
        'FolderKey',
        'Amount',
        'Remarks',
        'DateEncoded',
        'EncodedBy',
    ];

    protected $casts = [
        'Amount' => 'decimal:4',
        'DateEncoded' => 'datetime',
    ];

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'FolderKey', 'FolderKey');
    }

    // You might also want a hasMany relationship to CertificatesDtl
    // public function details(): HasMany
    // {
    //     return $this->hasMany(CertificatesDtl::class, 'CertNumber', 'CertNumber');
    // }
}
