<?php

namespace App\Exports;

use App\Models\AcctCode;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AccountCodesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return AcctCode::orderBy('AcctCode', 'asc')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'account_code',
            'type',
            'sub_type',
            'description',
            'account_type',
            'has_sl',
            'related_parent_code',
            'code_ext',
            'x_override',
            'account_class',
            'accumulated_depreciation_code',
            'cash_flow_type',
            'is_expense_analysis',
            'is_finance',
        ];
    }

    /**
     * @param mixed $acctCode
     * @return array
     */
    public function map($acctCode): array
    {
        return [
            $acctCode->AcctCode,
            $acctCode->Type,
            $acctCode->SubType,
            $acctCode->Description,
            $acctCode->AcctType,
            $acctCode->HasSL ? 'Yes' : 'No',
            $acctCode->RelatedParentCode,
            $acctCode->CodeExt,
            $acctCode->XOverride,
            $acctCode->AcctClass,
            $acctCode->AccumDepCode,
            $acctCode->CashFlowType,
            $acctCode->IsExpAnalysis ? 'Yes' : 'No',
            $acctCode->isFinance ? 'Yes' : 'No',
        ];
    }
}
