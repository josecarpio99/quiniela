<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepositRequest extends FormRequest
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
            'amount'  => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'date'    => ['required', 'date_format:Y-m-d'],
            'payment_reference' => ['required']
        ];
    }
}
