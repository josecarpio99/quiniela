<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends FormRequest
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
            'picks'   => ['required', 'array'],
            'picks.*.id' => ['required', 'exists:picks,id,ticket_id,' . $this->ticket->id],
            'picks.*.home_score' => ['required'],
            'picks.*.away_score' => ['required'],
        ];
    }
}
