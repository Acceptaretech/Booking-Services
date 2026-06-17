<?php

namespace App\Services\Provider;

use App\Models\User;
use App\Models\UserDocument;
use App\Services\Interfaces\ProviderAuthServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProviderAuthService implements ProviderAuthServiceInterface
{
    public function register($request)
    {
        return DB::transaction(function () use ($request) {

            $user = User::create([
                'username'     => $request->username,
                'first_name'   => $request->first_name,
                'last_name'    => $request->last_name,
                'email'        => $request->email,
                'phone'        => $request->phone,
                'country_code' => $request->country_code ?? '+91',
                'password'     => bcrypt($request->password),
                'role'         => 'provider',
                'designation'  => $request->designation,
                'zone_id'      => $request->zone_id,
                'status'       => 'pending',
            ]);

            $documents = [];

            foreach ([
                'passport',
                'driving_licence',
                'aadhar_card',
                'pan_card',
                'voting_card'
            ] as $doc) {

                if ($request->hasFile($doc)) {
                    $documents[$doc] =
                        $request->file($doc)
                        ->store('documents', 'public');
                }
            }

            UserDocument::create([
                'user_id' => $user->id,
                ...$documents
            ]);

            return $user;
        });
    }

    public function login(array $credentials)
    {
        $user = User::where('email', $credentials['email'])
            ->where('role', 'provider')
            ->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['Provider not found']
            ]);
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['Invalid password']
            ]);
        }

        if ($user->status !== 'active') {
            throw ValidationException::withMessages([
                'status' => ['Account pending admin approval']
            ]);
        }

        $token = $user->createToken('provider-token')->plainTextToken;

        return [
            'token' => $token,
            'user'  => $user
        ];
    }

    public function logout($user)
    {
        $user->currentAccessToken()->delete();

        return true;
    }

    public function profile($user)
    {
        return $user;
    }
}