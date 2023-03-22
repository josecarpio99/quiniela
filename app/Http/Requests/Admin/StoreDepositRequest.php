<?php

namespace App\Http\Requests\Admin;

use App\Enums\TransactionTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

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
            'user_id' => ['required', 'exists:users,id'],
            'amount' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'date'   => ['required', 'date_format:Y-m-d'],
            'payment_method' => ['required'],
            'payment_reference' => ['required'],
            'update_user_balance' => ['required', 'boolean']
        ];
    }
}
