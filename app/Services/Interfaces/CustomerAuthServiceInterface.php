<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface CustomerAuthServiceInterface
{
    public function register(Request $request);
    public function login(Request $request);
    public function logout(Request $request);
}