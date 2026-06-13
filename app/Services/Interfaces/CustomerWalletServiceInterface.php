<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface CustomerWalletServiceInterface
{
    public function index($user, Request $request);
    public function addBalance($user, Request $request);
}