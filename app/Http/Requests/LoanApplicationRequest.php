<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Clientele;

class LoanApplicationRequest extends FormRequest
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
            'ClientCode' => 'required|string|max:10',
            'DtOfApp' => 'nullable|date',
            'Approved' => 'nullable|boolean',
            'Remarks' => 'nullable|string|max:128',
            'RatingScore' => 'nullable|numeric|min:0|max:10',
            'LoanNumber' => 'nullable|integer|min:1',
            'LoanType' => 'required|integer|min:1',
            'LoanStatus' => 'required|integer|min:1',
            'AppRemarks' => 'nullable|string',
        ];

        // For updates, make LoanNumber unique except for current record
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $loanApplicationId = $this->route('loan_application')?->LACode;
            if ($this->filled('LoanNumber')) {
                $rules['LoanNumber'] .= '|unique:loan_applications,LoanNumber,' . $loanApplicationId . ',LACode';
            }
        } else {
            // For creation, make LoanNumber unique if provided
            if ($this->filled('LoanNumber')) {
                $rules['LoanNumber'] .= '|unique:loan_applications,LoanNumber';
            }
        }

        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'ClientCode' => 'client',
            'DtOfApp' => 'application date',
            'Approved' => 'approval status',
            'Remarks' => 'remarks',
            'RatingScore' => 'rating score',
            'LoanNumber' => 'loan number',
            'LoanType' => 'loan type',
            'LoanStatus' => 'loan status',
            'AppRemarks' => 'application remarks',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'ClientCode.required' => 'Please enter a client code for this loan application.',
            'LoanType.required' => 'Please select a loan type.',
            'LoanStatus.required' => 'Please select a loan status.',
            'RatingScore.numeric' => 'Rating score must be a valid number.',
            'RatingScore.min' => 'Rating score must be at least 0.',
            'RatingScore.max' => 'Rating score cannot exceed 10.',
            'LoanNumber.unique' => 'This loan number is already in use.',
            'LoanNumber.integer' => 'Loan number must be a valid integer.',
            'LoanNumber.min' => 'Loan number must be greater than 0.',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Validate that ClientCode exists in the clienteles table
            if ($this->filled('ClientCode')) {
                $client = Clientele::where('ClientCode', $this->ClientCode)->first();
                if (!$client) {
                    $validator->errors()->add('ClientCode', 'The selected client does not exist.');
                }
            }
        });
    }
}
