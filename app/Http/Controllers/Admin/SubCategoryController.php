<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Category, SubCategory};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubCategoryController extends Controller
{
    public function index(Request $request)
    {
        $subs = SubCategory::with('category')
            ->when($request->search, fn($q) => $q->where('name','like','%'.$request->search.'%'))
            ->latest()->paginate(10);
        return view('admin.sub-categories.index', compact('subs'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        return view('admin.sub-categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
            'status'      => 'required|in:active,inactive',
        ]);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('subcategories','public');
        }
        SubCategory::create($data);
        return redirect()->route('admin.sub-categories.index')->with('success','Sub-category created.');
    }

    public function edit(SubCategory $subCategory)
    {
        $categories = Category::active()->get();
        return view('admin.sub-categories.edit', compact('subCategory','categories'));
    }

    public function update(Request $request, SubCategory $subCategory)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
            'status'      => 'required|in:active,inactive',
        ]);
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($subCategory->image);
            $data['image'] = $request->file('image')->store('subcategories','public');
        }
        $subCategory->update($data);
        return redirect()->route('admin.sub-categories.index')->with('success','Sub-category updated.');
    }

    public function destroy(SubCategory $subCategory)
    {
        Storage::disk('public')->delete($subCategory->image);
        $subCategory->delete();
        return back()->with('success','Sub-category deleted.');
    }

    public function show(SubCategory $subCategory)
    {
        return view('admin.sub-categories.show', compact('subCategory'));
    }
}


// ── Admin Service ─────────────────────────────────────────────────────────────
