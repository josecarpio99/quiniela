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
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        if (! Auth::attempt($validated)) {
            return $this->unauthorized();
        }

        $user = User::where('email', $request->email)->first();

        return $this->success('User login successfully', [
            'token' => $user->createToken('User ' . $user->name . 'token')->plainTextToken,
            'user'  => $user
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return $this->success('User created successfully', [
            'token' => $user->createToken('User ' . $user->name . 'token')->plainTextToken,
            'user'  => $user
        ], 201);
    }
}
