<?php

namespace App\Http\Requests;

use Closure;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'name' => ['required', 'max:255'],
            'current_password' => [
                'nullable',
                'min:8',
                function (string $attribute, mixed $value, Closure $fail) {

                    if ( ! Hash::check($value, $this->user->getAuthPassword()) ) {
                        $fail("Password dont match");
                    }
                },
            ],
            'new_password' => ['required_with:current_password', 'min:8']
        ];
    }
}
