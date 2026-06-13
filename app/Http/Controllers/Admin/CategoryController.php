<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $cats = Category::withCount('services')
            ->when($request->search, fn($q) => $q->where('name', 'like', '%' . $request->search . '%'))
            ->latest()
            ->paginate(10);

        return view('admin.categories.index', compact('cats'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string',
            'image'       => 'required|image|max:2048',
            'status'      => 'required|in:active,inactive',
            'is_featured' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $data['is_featured'] = $request->boolean('is_featured');

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category created.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
            'status'      => 'required|in:active,inactive',
            'is_featured' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {

            if (!empty($category->image) && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $data['is_featured'] = $request->boolean('is_featured');

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        if (!empty($category->image) && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return back()->with('success', 'Category deleted.');
    }

    public function toggleStatus(Category $category)
    {
        $category->update([
            'status' => $category->status === 'active' ? 'inactive' : 'active'
        ]);

        return response()->json(['status' => $category->status]);
    }
}