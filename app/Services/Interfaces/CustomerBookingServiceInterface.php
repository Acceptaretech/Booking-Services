<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface CustomerBookingServiceInterface
{
    public function index($user, Request $request);
    public function store($user, Request $request, $serviceId);
    public function show($user, $bookingId);
}