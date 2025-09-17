<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcctCode extends Model
{
    use HasFactory;
    
    protected $table = 'acct_codes';
    protected $primaryKey = 'AcctCode';
    public $incrementing = false;
    protected $keyType = 'string';
    
    // Adding timestamps since we see created_at and updated_at in the schema
    protected $fillable = [
        'AcctCode',
        'Type',
        'SubType',
        'Description',
        'AcctType',
        'HasSL',
        'RelatedParentCode',
        'CodeExt',
        'XOverride',
        'AcctClass',
        'AccumDepCode',
        'CashFlowType',
        'IsExpAnalysis',
        'isFinance',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'Type' => 'integer',
        'SubType' => 'integer',
        'AcctType' => 'integer',
        'HasSL' => 'boolean',
        'CodeExt' => 'integer',
        'XOverride' => 'integer',
        'AcctClass' => 'integer',
        'CashFlowType' => 'integer',
        'IsExpAnalysis' => 'boolean',
        'isFinance' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    /**
     * Get the parent account code if there is one.
     */
    public function parentAccount()
    {
        return $this->belongsTo(AcctCode::class, 'RelatedParentCode', 'AcctCode');
    }
    
    /**
     * Get child account codes that use this as their parent.
     */
    public function childAccounts()
    {
        return $this->hasMany(AcctCode::class, 'RelatedParentCode', 'AcctCode');
    }
    
    /**
     * Get the account code related to accumulated depreciation.
     */
    public function accumulatedDepreciation()
    {
        return $this->belongsTo(AcctCode::class, 'AccumDepCode', 'AcctCode');
    }
    
    /**
     * Get the type name for display purposes.
     */
    public function getTypeNameAttribute()
    {
        $types = [
            1 => 'Asset',
            2 => 'Liability',
            3 => 'Equity',
            4 => 'Income',
            5 => 'Expense',
            // Add more types as needed
        ];
        
        return $types[$this->Type] ?? 'Type ' . $this->Type;
    }
    
    /**
     * Get the SubType name for display purposes.
     */
    public function getSubTypeNameAttribute()
    {
        $subtypes = [
            1 => 'Current',
            2 => 'Non-Current',
            3 => 'Fixed',
            4 => 'Operating',
            5 => 'Non-Operating',
            // Add more subtypes as needed
        ];
        
        return $subtypes[$this->SubType] ?? ($this->SubType ? 'SubType ' . $this->SubType : null);
    }
    
    /**
     * Get the AcctType name for display purposes.
     */
    public function getAcctTypeNameAttribute()
    {
        $acctTypes = [
            1 => 'Debit',
            2 => 'Credit',
            // Add more types as needed
        ];
        
        return $acctTypes[$this->AcctType] ?? ($this->AcctType ? 'AcctType ' . $this->AcctType : null);
    }
    
    /**
     * Get formatted representation of boolean fields.
     */
    public function getHasSLTextAttribute()
    {
        return $this->HasSL ? 'Yes' : 'No';
    }
    
    public function getIsExpAnalysisTextAttribute()
    {
        return $this->IsExpAnalysis ? 'Yes' : 'No';
    }
    
    public function getIsFinanceTextAttribute()
    {
        return $this->isFinance ? 'Yes' : 'No';
    }
}
