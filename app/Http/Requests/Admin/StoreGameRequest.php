<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreGameRequest extends FormRequest
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
            'home_team'  => ['required', 'exists:teams,id'],
            'away_team'  => ['required', 'exists:teams,id'],
            'home_score' => ['integer'],
            'away_score' => ['integer'],
            'start_at'   => ['required', 'date_format:Y-m-d H:i']
        ];
    }
}
