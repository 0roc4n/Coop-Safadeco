<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class ClientLoan extends Model
{
    use HasFactory;

    protected $table = 'clienclient_loanstloans';
    protected $primaryKey = 'CLKey';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'LACode',
        'AcctCode',
        'ClientCode',
        'Amount',
        'UnearnedInterest',
        'InterestEarned',
        'DateReleased',
        'EndDate',
        'Balance',
        'LoanPaid',
        'Remarks',
        'FolderKey',
        'LoanType',
        'LoanTrans',
        'AmortTerm',
        'AmortType',
        'PrinMOP',
        'MOP',
        'MonthlyPymt',
        'PymtCounter',
        'Rate',
        'Interest',
        'OrigPymtDate',
        'PrinBal',
        'IntBal',
        'PrincipalPaid',
        'InterestPaid',
        'PenaltyBal',
        'PenaltyPaid',
        'PrincipalDue',
        'InterestDue',
        'FSav1Bal',
        'FSav1Paid',
        'FSav1Due',
        'FSav2Bal',
        'FSav2Paid',
        'FSav2Due',
        'FSav3Bal',
        'FSav3Paid',
        'FSav3Due',
        'FSav4Bal',
        'FSav4Paid',
        'FSav4Due',
        'FSav5Bal',
        'FSav5Paid',
        'FSav5Due',
        'TermQty',
        'TermTime',
        'Principal_Amortized',
        'Interest_Amortized',
        'AmortTypeCD',
        'TransCode',
        'TransCodeJV',
        'PrincipalCap',
        'PenaltyCap',
        'Collateral',
        'CoMaker',
        'RestructuredFrom',
        'RestructuredTo',
        'RebateAmount',
        'CloseTranCode',
        'ClosedDate',
        'CreatedBy',
        'DateCreated',
        'UpdatedBy',
        'DateUpdated',
    ];

    protected $casts = [
        'Amount' => 'decimal:4',
        'UnearnedInterest' => 'decimal:4',
        'InterestEarned' => 'decimal:4',
        'DateReleased' => 'datetime',
        'EndDate' => 'datetime',
        'Balance' => 'decimal:4',
        'LoanPaid' => 'boolean',
        'LoanType' => 'boolean',
        'LoanTrans' => 'boolean',
        'MonthlyPymt' => 'decimal:4',
        'Rate' => 'decimal:4',
        'Interest' => 'decimal:4',
        'OrigPymtDate' => 'datetime',
        'PrinBal' => 'decimal:4',
        'IntBal' => 'decimal:4',
        'PrincipalPaid' => 'decimal:4',
        'InterestPaid' => 'decimal:4',
        'PenaltyBal' => 'decimal:4',
        'PenaltyPaid' => 'decimal:4',
        'PrincipalDue' => 'decimal:4',
        'InterestDue' => 'decimal:4',
        'FSav1Bal' => 'decimal:4',
        'FSav1Paid' => 'decimal:4',
        'FSav1Due' => 'decimal:4',
        'FSav2Bal' => 'decimal:4',
        'FSav2Paid' => 'decimal:4',
        'FSav2Due' => 'decimal:4',
        'FSav3Bal' => 'decimal:4',
        'FSav3Paid' => 'decimal:4',
        'FSav3Due' => 'decimal:4',
        'FSav4Bal' => 'decimal:4',
        'FSav4Paid' => 'decimal:4',
        'FSav4Due' => 'decimal:4',
        'FSav5Bal' => 'decimal:4',
        'FSav5Paid' => 'decimal:4',
        'FSav5Due' => 'decimal:4',
        'Principal_Amortized' => 'decimal:4',
        'Interest_Amortized' => 'decimal:4',
        'AmortTypeCD' => 'boolean',
        'PrincipalCap' => 'decimal:4',
        'PenaltyCap' => 'decimal:4',
        'RebateAmount' => 'decimal:4',
        'ClosedDate' => 'datetime',
        'DateCreated' => 'datetime',
        'DateUpdated' => 'datetime',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Clientele::class, 'ClientCode', 'ClientCode');
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(ChartOfAccount::class, 'AcctCode', 'AcctCode');
    }

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'FolderKey', 'FolderKey');
    }

    public function transactionOperation(): BelongsTo
    {
        return $this->belongsTo(BussOperation::class, 'TransCode', 'BussOpCode');
    }

    public function journalVoucherOperation(): BelongsTo
    {
        return $this->belongsTo(BussOperation::class, 'TransCodeJV', 'BussOpCode');
    }

    public function restructuredFromLoan(): BelongsTo
    {
        return $this->belongsTo(ClientLoan::class, 'RestructuredFrom', 'CLKey');
    }

    public function restructuredToLoan(): HasOne
    {
        return $this->hasOne(ClientLoan::class, 'RestructuredTo', 'CLKey');
    }

    public function collateral(): HasMany
    {
        return $this->hasMany(ClCollateral::class, 'CLKey', 'CLKey');
    }

    public function customInterests(): HasMany
    {
        return $this->hasMany(ClCustomInterest::class, 'CLKey', 'CLKey');
    }

    public function coMakers(): HasMany
    {
        return $this->hasMany(ClientComaker::class, 'CLKey', 'CLKey');
    }

    // public function createdBy(): BelongsTo
    // {
    //     return $this->belongsTo(User::class, 'CreatedBy', 'UserID'); // Assuming a User model and UserID as PK
    // }

    // public function updatedBy(): BelongsTo
    // {
    //     return $this->belongsTo(User::class, 'UpdatedBy', 'UserID'); // Assuming a User model and UserID as PK
    // }
}
