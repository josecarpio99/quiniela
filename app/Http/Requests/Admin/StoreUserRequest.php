<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'username' => ['required', 'min:4', 'max:20', 'alpha_num', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'name' => ['required', 'max:255'],
            'password' => ['required', 'min:8', 'max:255', 'confirmed'],
        ];
    }
}
