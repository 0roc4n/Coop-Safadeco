<?php

namespace App\Imports;

use App\Models\AcctCode;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;

class AccountCodesImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Handle boolean conversions
        $hasSL = $this->convertToBoolean($row['has_sl'] ?? false);
        $isExpAnalysis = $this->convertToBoolean($row['is_expense_analysis'] ?? false);
        $isFinance = $this->convertToBoolean($row['is_finance'] ?? null);

        return new AcctCode([
            'AcctCode' => $row['account_code'],
            'Type' => (int) $row['type'],
            'SubType' => !empty($row['sub_type']) ? (int) $row['sub_type'] : null,
            'Description' => $row['description'] ?? null,
            'AcctType' => !empty($row['account_type']) ? (int) $row['account_type'] : null,
            'HasSL' => $hasSL,
            'RelatedParentCode' => $row['related_parent_code'] ?? null,
            'CodeExt' => (int) ($row['code_ext'] ?? 0),
            'XOverride' => (int) ($row['x_override'] ?? 0),
            'AcctClass' => !empty($row['account_class']) ? (int) $row['account_class'] : null,
            'AccumDepCode' => $row['accumulated_depreciation_code'] ?? null,
            'CashFlowType' => (int) ($row['cash_flow_type'] ?? 0),
            'IsExpAnalysis' => $isExpAnalysis,
            'isFinance' => $isFinance,
        ]);
    }

    /**
     * Convert string values to boolean
     */
    private function convertToBoolean($value)
    {
        if (is_bool($value)) {
            return $value;
        }
        
        if (is_string($value)) {
            $value = strtolower(trim($value));
            return in_array($value, ['yes', '1', 'true', 'on']);
        }
        
        return (bool) $value;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'account_code' => 'required|string|max:12|unique:acct_codes,AcctCode',
            'type' => 'required|integer',
            'sub_type' => 'nullable|integer',
            'description' => 'nullable|string|max:64',
            'account_type' => 'nullable|integer',
            'has_sl' => 'required',
            'related_parent_code' => 'nullable|string|max:12',
            'code_ext' => 'required|integer',
            'x_override' => 'required|integer',
            'account_class' => 'nullable|integer',
            'accumulated_depreciation_code' => 'nullable|string|max:12',
            'cash_flow_type' => 'required|integer',
            'is_expense_analysis' => 'required',
            'is_finance' => 'nullable',
        ];
    }

    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'account_code.required' => 'Account Code is required.',
            'account_code.unique' => 'Account Code already exists.',
            'type.required' => 'Type is required.',
            'has_sl.required' => 'Has SL is required.',
            'code_ext.required' => 'Code Ext is required.',
            'x_override.required' => 'X Override is required.',
            'cash_flow_type.required' => 'Cash Flow Type is required.',
            'is_expense_analysis.required' => 'Is Expense Analysis is required.',
        ];
    }
}