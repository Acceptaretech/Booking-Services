<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface HomeServiceInterface
{
    public function home();
    public function categories(Request $request);
    public function services(Request $request);
    public function serviceDetail($id);
    public function providers(Request $request);
    public function providerDetail($id);
    public function blogs(Request $request);
    public function blogDetail($id);
}