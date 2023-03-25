<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;
use App\Enums\TransactionStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class ChangeWithdrawStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'status' => [
                'required',
                Rule::in(TransactionStatusEnum::allExceptFor($this->withdraw->status))
            ]
        ];
    }
}
