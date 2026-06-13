<?php

namespace App\Services\Customer;

use App\Models\User;
use App\Services\Interfaces\CustomerAuthServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CustomerAuthService implements CustomerAuthServiceInterface
{
    
    public function register(Request $request)
    {
        $data = $request->validate([
            'username'   => 'required|string|max:50|unique:users,username',
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|email|unique:users,email',
            'phone'      => 'required|string|max:20|unique:users,phone',
            'password'   => 'required|string|min:8|confirmed',
        ], [
            'username.unique' => 'Username already exists.',
            'email.unique'    => 'Email already exists.',
            'phone.unique'    => 'Phone number already exists.',
        ]);

        $user = User::create([
            'username'   => $data['username'],
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => $data['email'],
            'phone'      => $data['phone'],
            'password'   => Hash::make($data['password']),
            'role'       => 'customer',
            'status'     => 'active',
        ]);

        $token = $user->createToken('customer-token')->plainTextToken;

        return [
            'user' => $user,
            'token_type' => 'Bearer',
            'token' => $token,
        ];
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('role', 'customer')
            ->where(function ($query) use ($data) {
                $query->where('email', $data['email'])
                      ->orWhere('username', $data['email'])
                      ->orWhere('phone', $data['email']);
            })
            ->first();
            if (!$user || !Hash::check($data['password'], $user->password)) {
                return [
                    'error' => true,
                    'status' => 401,
                    'message' => 'Invalid email or password.'
                ];
            }

        if ($user->status !== 'active') {
            return [
                'error' => true,
                'status' => 403,
                'message' => 'Your account is not active'
            ];
        }

        $token = $user->createToken('customer-token')->plainTextToken;

        return [
            'user' => $user,
            'token_type' => 'Bearer',
            'token' => $token,
        ];
    }

    public function logout(Request $request)
    {
        if ($request->user() && $request->user()->currentAccessToken()) {
            $request->user()->currentAccessToken()->delete();
        }

        return true;
    }
}