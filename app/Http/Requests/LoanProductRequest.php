<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoanProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            // Basic Information
            'LoanCode' => [
                'required',
                'string',
                'max:12',
                $this->isMethod('post') 
                    ? Rule::unique('loan_products', 'LoanCode')
                    : Rule::unique('loan_products', 'LoanCode')->ignore($this->route('loanProduct'), 'LoanCode')
            ],
            'LoanType' => 'required|integer|min:1|max:5',
            'Description' => 'required|string|max:64',
            
            // Interest and Rates
            'InterestRate' => 'required|numeric|min:0|max:100',
            'IRate' => 'required|numeric|min:0|max:100',
            'MinInterestRate' => 'nullable|numeric|min:0|max:100',
            'MaxInterestRate' => 'nullable|numeric|min:0|max:100',
            'PenaltyRate' => 'nullable|numeric|min:0|max:100',
            
            // Loan Amounts
            'LoanAmount' => 'required|numeric|min:0',
            'MinLoanAmount' => 'required|numeric|min:0',
            'MaxLoanAmount' => 'required|numeric|min:0|gte:MinLoanAmount',
            
            // Terms
            'LoanTerm' => 'nullable|integer|min:1',
            'MinTerm' => 'required|integer|min:1',
            'MaxTerm' => 'required|integer|min:1|gte:MinTerm',
            'TermQty' => 'nullable|integer|min:1',
            'GracePeriod' => 'nullable|integer|min:0',
            'PenaltyGracePeriod' => 'nullable|integer|min:0',
            
            // Fees
            'ServCharge' => 'required|numeric|min:0',
            'ServChargeType' => 'required|integer|min:0',
            'DocStamp' => 'required|numeric|min:0',
            'DocStampType' => 'required|integer|min:0',
            'MRI' => 'required|numeric|min:0',
            'MRIType' => 'required|integer|min:0',
            'NotarialFee' => 'required|numeric|min:0',
            'NotarialFeeType' => 'required|integer|min:0',
            'FilingFee' => 'required|numeric|min:0',
            'FilingFeeType' => 'required|integer|min:0',
            'CIBI' => 'required|numeric|min:0',
            'CIBIType' => 'required|integer|min:0',
            'AFees' => 'required|numeric|min:0',
            'AFeesType' => 'required|integer|min:0',
            'CBAmount' => 'required|numeric|min:0',
            'CBType' => 'required|integer|min:0',
            
            // Modes of Payment
            'PrincipalMOP' => 'required|integer|min:0',
            'InterestMOP' => 'required|integer|min:0',
            'Compounding' => 'required|integer|min:0',
            'PenaltyComp' => 'required|integer|min:0',
            'LoanTerm' => 'required|integer|min:0',
            'TermQty' => 'required|integer|min:0',
            
            // Boolean Flags
            'HasCollateral' => 'boolean',
            'HasCoMaker' => 'boolean',
            'FixedRate' => 'boolean',
            'AutoPenalty' => 'boolean',
            'LoanTerminMaturity' => 'boolean',
            
            // Use Modes
            'PrinUseMode' => 'required|integer|min:0',
            'IntUseMode' => 'required|integer|min:0',
            'SavingsUseMode' => 'required|integer|min:0',
            'LoanProdGroup' => 'required|integer|min:0',
            
            // Savings Accounts
            'FSav1' => 'nullable|string|max:12',
            'FSav2' => 'nullable|string|max:12',
            'FSav3' => 'nullable|string|max:12',
            'FSav4' => 'nullable|string|max:12',
            'FSav5' => 'nullable|string|max:12',
            'FSav1Type' => 'required|integer|min:0',
            'FSav2Type' => 'required|integer|min:0',
            'FSav3Type' => 'required|integer|min:0',
            'FSav4Type' => 'required|integer|min:0',
            'FSav5Type' => 'required|integer|min:0',
            
            // Account Codes
            'PenaltyGL' => 'nullable|string|max:12',
            'AcctCode_Penalty' => 'nullable|string|max:12',
            'AcctCode_ServiceCharge' => 'nullable|string|max:12',
            'AcctCode_DocumentStamp' => 'nullable|string|max:12',
            'AcctCode_MRI' => 'nullable|string|max:12',
            'AcctCode_NotarialFee' => 'nullable|string|max:12',
            'AcctCode_FilingFee' => 'nullable|string|max:12',
            'AcctCode_CIBI' => 'nullable|string|max:12',
            'AcctCode_AFees' => 'nullable|string|max:12',
            'AcctCode_CB' => 'nullable|string|max:12',
            
            // Additional Fields
            'PenaltyComputedPer' => 'nullable|numeric|min:0',
        ];

        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'LoanCode' => 'loan code',
            'LoanType' => 'loan type',
            'Description' => 'description',
            'InterestRate' => 'interest rate',
            'LoanAmount' => 'loan amount',
            'MinLoanAmount' => 'minimum loan amount',
            'MaxLoanAmount' => 'maximum loan amount',
            'MinTerm' => 'minimum term',
            'MaxTerm' => 'maximum term',
            'HasCollateral' => 'collateral requirement',
            'HasCoMaker' => 'co-maker requirement',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'LoanCode.required' => 'Please enter a loan code.',
            'LoanCode.unique' => 'This loan code is already in use.',
            'LoanType.required' => 'Please select a loan type.',
            'Description.required' => 'Please enter a description.',
            'InterestRate.required' => 'Please enter an interest rate.',
            'LoanAmount.required' => 'Please enter a loan amount.',
            'MinLoanAmount.required' => 'Please enter a minimum loan amount.',
            'MaxLoanAmount.required' => 'Please enter a maximum loan amount.',
            'MaxLoanAmount.gte' => 'Maximum loan amount must be greater than or equal to minimum loan amount.',
            'MinTerm.required' => 'Please enter a minimum term.',
            'MaxTerm.required' => 'Please enter a maximum term.',
            'MaxTerm.gte' => 'Maximum term must be greater than or equal to minimum term.',
            'InterestRate.max' => 'Interest rate cannot exceed 100%.',
            'InterestRate.min' => 'Interest rate must be at least 0%.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $data = [];
        
        // Convert string numbers to integers/floats
        if ($this->filled('LoanType')) {
            $data['LoanType'] = (int) $this->input('LoanType');
        }
        
        // Ensure IRate is set to InterestRate if not provided
        if ($this->filled('InterestRate') && !$this->filled('IRate')) {
            $data['IRate'] = $this->input('InterestRate');
        }
        
        // Convert boolean strings to actual booleans
        $data['HasCollateral'] = $this->boolean('HasCollateral');
        $data['HasCoMaker'] = $this->boolean('HasCoMaker');
        $data['FixedRate'] = $this->boolean('FixedRate');
        $data['AutoPenalty'] = $this->boolean('AutoPenalty');
        $data['LoanTerminMaturity'] = $this->boolean('LoanTerminMaturity');
        
        // Convert numeric strings to proper numbers with defaults
        $numericFields = [
            'IRate', 'InterestRate', 'MinInterestRate', 'MaxInterestRate',
            'LoanAmount', 'MinLoanAmount', 'MaxLoanAmount',
            'MinTerm', 'MaxTerm', 'GracePeriod', 'PenaltyGracePeriod',
            'ServCharge', 'DocStamp', 'MRI', 'NotarialFee', 'FilingFee', 'PenaltyRate',
            'CIBI', 'AFees', 'CBAmount', 'PenaltyComputedPer'
        ];
        
        foreach ($numericFields as $field) {
            if ($this->filled($field) && is_numeric($this->input($field))) {
                $data[$field] = (float) $this->input($field);
            } else {
                $data[$field] = 0.00; // Set default value for required numeric fields
            }
        }
        
        // Convert integer fields with default values
        $integerFields = [
            'Compounding', 'LoanTerm', 'TermQty', 'PrincipalMOP', 'InterestMOP', 'PenaltyComp',
            'ServChargeType', 'DocStampType', 'MRIType', 'NotarialFeeType', 'FilingFeeType',
            'CIBIType', 'AFeesType', 'CBType', 'PrinUseMode', 'IntUseMode', 'SavingsUseMode',
            'LoanProdGroup', 'FSav1Type', 'FSav2Type', 'FSav3Type', 'FSav4Type', 'FSav5Type'
        ];
        
        foreach ($integerFields as $field) {
            if ($this->filled($field)) {
                $data[$field] = (int) $this->input($field);
            } else {
                $data[$field] = 0; // Set default value for required integer fields
            }
        }
        
        $this->merge($data);
    }
}
