<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface CustomerAddressServiceInterface
{
    public function index($user);
    public function store($user, Request $request);
    public function update($user, Request $request, $addressId);
    public function delete($user, $addressId);
    public function makeDefault($user, $addressId);
}