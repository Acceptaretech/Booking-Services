<?php

namespace App\Services\Public;

use App\Models\Page;

class PageService
{
    public function show($slug)
    {
        return Page::where('slug', $slug)
            ->where('status', 1)
            ->first();
    }
}