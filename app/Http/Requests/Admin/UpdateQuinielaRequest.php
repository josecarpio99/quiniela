<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuinielaRequest extends FormRequest
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
            'type'             => ['in:1,2'],
            'is_active'        => ['boolean'],
            'has_three_for_two' => ['required','boolean'],
            'ticket_price'     => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'close_at'         => ['required', 'date_format:Y-m-d H:i'],
            'prize.*.position' => ['required', 'integer'],
            'prize.*.amount'   => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'games'            => ['required'],
            'games.*.id'       => ['required', 'exists:games,id'],
        ];
    }
}
