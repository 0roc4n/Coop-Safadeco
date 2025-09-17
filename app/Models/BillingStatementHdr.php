<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingStatementHdr extends Model
{
    use HasFactory;
    
    protected $table = 'billingstatementhdr';
    protected $primaryKey = 'BillingHdrID';
    public $timestamps = false;

    protected $fillable = [
        'BillingDate',
        'DocumentNo',
        'Remarks',
        'PymtDate',
        'DateGenerated',
        'TransCode',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'BillingDate' => 'datetime',
        'PymtDate' => 'datetime',
        'DateGenerated' => 'datetime',
    ];

    /**
     * Get the billing statements associated with the header.
     */
    public function billingStatements()
    {
        return $this->hasMany(BillingStatement::class, 'BillHdrID', 'BillingHdrID');
    }

    /**
     * Scope a query to only include billing statements from a specific date range.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $from
     * @param  string  $to
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDateRange($query, $from, $to)
    {
        return $query->whereBetween('BillingDate', [
            Carbon::parse($from)->startOfDay(),
            Carbon::parse($to)->endOfDay()
        ]);
    }

    /**
     * Scope a query to only include paid billing statements.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePaid($query)
    {
        return $query->whereNotNull('PymtDate');
    }

    /**
     * Scope a query to only include unpaid billing statements.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnpaid($query)
    {
        return $query->whereNull('PymtDate');
    }

    /**
     * Scope a query to filter by transaction code.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $transCode
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithTransCode($query, $transCode)
    {
        return $query->where('TransCode', $transCode);
    }
    
    /**
     * Get the formatted billing date.
     *
     * @return string
     */
    public function getFormattedBillingDateAttribute()
    {
        return $this->BillingDate ? Carbon::parse($this->BillingDate)->format('M d, Y') : null;
    }
    
    /**
     * Get the formatted payment date.
     *
     * @return string
     */
    public function getFormattedPymtDateAttribute()
    {
        return $this->PymtDate ? Carbon::parse($this->PymtDate)->format('M d, Y') : 'Not Paid';
    }
    
    /**
     * Check if billing statement is paid.
     *
     * @return bool
     */
    public function getIsPaidAttribute()
    {
        return $this->PymtDate !== null;
    }
}
