<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function edit($slug)
    {
        $title = Str::title(str_replace('-', ' ', $slug));

        $page = Page::firstOrCreate(
            ['slug' => $slug],
            [
                'title' => $title,
                'content' => '',
                'status' => 1,
            ]
        );

        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, $slug)
    {
        $request->validate([
            'content' => 'required',
            'status' => 'nullable',
        ]);

        $page = Page::where('slug', $slug)->firstOrFail();

        $page->update([
            'content' => $request->content,
            'status' => $request->has('status') ? 1 : 0,
        ]);

        return back()->with('success', 'Page updated successfully.');
    }
}