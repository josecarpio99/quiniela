<?php

namespace App\Http\Requests\Admin;

use App\Enums\BalanceHistoryOperationEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateUserBalanceRequest extends FormRequest
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
            'amount' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'operation' => ['required', new Enum(BalanceHistoryOperationEnum::class)],
            'concept' => ['required', 'string']
        ];
    }
}
