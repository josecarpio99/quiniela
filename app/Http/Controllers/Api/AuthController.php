<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends ApiController
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|max:255',
            'password' => 'required'
        ]);


        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (
            ! Auth::attempt([
                $fieldType => $request->username, 'password' => $request->password
            ])
        ) {
            return $this->unauthorized();
        }

        $user = User::where($fieldType, $request->username)->first();

        return $this->success('User login successfully', [
            'token' => $user->createToken('User ' . $user->name . 'token')->plainTextToken,
            'user'  => $user
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'min:4', 'max:20', 'alpha_num', 'unique:users,username'],
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return $this->success('User created successfully', [
            'token' => $user->createToken('User ' . $user->name . 'token')->plainTextToken,
            'user'  => $user
        ], 201);
    }
}
