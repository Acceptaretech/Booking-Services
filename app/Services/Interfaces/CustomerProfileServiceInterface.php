<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface CustomerProfileServiceInterface
{
    public function profile($user);
    public function update(Request $request, $user);
}