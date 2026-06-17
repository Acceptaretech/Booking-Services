<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface ProviderAuthServiceInterface
{
    public function register(Request $request);

    public function login(array $credentials);

    public function logout($user);

    public function profile($user);
}