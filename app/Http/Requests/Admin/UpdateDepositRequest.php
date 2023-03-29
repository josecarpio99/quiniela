<?php

namespace App\Http\Requests\Admin;

use App\Models\Transaction;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDepositRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'amount' => [
                'required',
                'regex:/^\d+(\.\d{1,2})?$/',
                'gte:' . Transaction::MIN_DEPOSIT_AMOUNT
            ],
            'date'   => ['required', 'date_format:Y-m-d'],
            'payment_method' => ['required', 'integer', 'exists:payment_methods,id'],
            'payment_reference' => ['required']
        ];
    }
}
