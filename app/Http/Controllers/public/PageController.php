<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
class PageController extends Controller
{
    public function show($slug)
    {
        $page = Page::where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        return view('public.pages.show', compact('page'));
    }
}
