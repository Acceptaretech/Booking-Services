<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    // public function index(Request $request)
    // {
    //     $blogs = Blog::with('author')
    //         ->when($request->search, fn($q)=>$q->where('title','like','%'.$request->search.'%'))
    //         ->latest()->paginate(10);
    //     return view('admin.blogs.index', compact('blogs'));
    // }

    // public function create()
    // {
    //     return view('admin.blogs.create');
    // }

    // public function store(Request $request)
    // {
    //     $data = $request->validate([
    //         'title'   => 'required|string|max:200',
    //         'content' => 'required|string',
    //         'image'   => 'nullable|image|max:4096',
    //         'status'  => 'required|in:published,draft',
    //     ]);
    //     if ($request->hasFile('image')) {
    //         $data['image'] = $request->file('image')->store('blogs','public');
    //     }
    //     $data['author_id']     = auth()->id();
    //     $data['slug']          = Str::slug($data['title']).'-'.time();
    //     $data['published_at']  = $data['status'] === 'published' ? now() : null;
    //     Blog::create($data);
    //     return redirect()->route('admin.blogs.index')->with('success','Blog published.');
    // }

    // public function show(Blog $blog) { return view('admin.blogs.show', compact('blog')); }

    // public function edit(Blog $blog)
    // {
    //     return view('admin.blogs.edit', compact('blog'));
    // }

    // public function update(Request $request, Blog $blog)
    // {
    //     $data = $request->validate(['title'=>'required','content'=>'required','status'=>'required']);
    //     if ($request->hasFile('image')) {
    //         Storage::disk('public')->delete($blog->image);
    //         $data['image'] = $request->file('image')->store('blogs','public');
    //     }
    //     if ($data['status']==='published' && !$blog->published_at) {
    //         $data['published_at'] = now();
    //     }
    //     $blog->update($data);
    //     return redirect()->route('admin.blogs.index')->with('success','Blog updated.');
    // }

    // public function destroy(Blog $blog)
    // {
    //     Storage::disk('public')->delete($blog->image);
    //     $blog->delete();
    //     return back()->with('success','Blog deleted.');
    // }
    public function index(Request $request)
    {
        $query = Blog::with('author');

        if($request->search){
            $query->where('title','like','%'.$request->search.'%');
        }

        if($request->status){
            $query->where('status',$request->status);
        }

        $blogs = $query->latest()->paginate(10);

        return view('admin.blogs.index',compact('blogs'));
    }

    public function create()
    {
        $authors = User::where('role', 'provider')->get();

        return view(
            'admin.blogs.create',
            compact('authors')
        );
    }
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required|max:255',
            'author_id'=>'required',
            'content'=>'required',
            'status'=>'required'
        ]);

        $image = null;

        if($request->hasFile('image')){
            $image = $request
                ->file('image')
                ->store('blogs','public');
        }

        Blog::create([
            'author_id'=>$request->author_id,
            'title'=>$request->title,
            'slug'=>Str::slug($request->title),
            'content'=>$request->content,
            'image'=>$image,
            'meta_title'=>$request->meta_title,
            'meta_description'=>$request->meta_description,
            'read_time'=>$request->read_time,
            'status'=>$request->status,
            'published_at'=>now()
        ]);

        return redirect()
            ->route('admin.blogs.index')
            ->with('success','Blog created');
    }

    public function edit(Blog $blog)
    {
        $authors = User::all();

        return view(
            'admin.blogs.edit',
            compact('blog','authors')
        );
    }

    public function update(Request $request,Blog $blog)
    {
        $image = $blog->image;

        if($request->hasFile('image')){

            if($blog->image){
                Storage::disk('public')
                    ->delete($blog->image);
            }

            $image = $request
                ->file('image')
                ->store('blogs','public');
        }

        $blog->update([
            'author_id'=>$request->author_id,
            'title'=>$request->title,
            'slug'=>Str::slug($request->title),
            'content'=>$request->content,
            'image'=>$image,
            'meta_title'=>$request->meta_title,
            'meta_description'=>$request->meta_description,
            'read_time'=>$request->read_time,
            'status'=>$request->status
        ]);

        return redirect()
            ->route('admin.blogs.index')
            ->with('success','Blog updated');
    }
    public function destroy(Blog $blog)
    {
        $blog->delete();

        return back()
            ->with('success','Deleted');
    }
    public function toggleStatus(Blog $blog)
    {
        $blog->update([
            'status'=>
            $blog->status == 'published'
                ? 'draft'
                : 'published'
        ]);

        return back();
    }
    public function bulkAction(Request $request)
    {
        if($request->action == 'delete'){
            Blog::whereIn(
                'id',
                $request->ids
            )->delete();
        }

        return back();
    }
}


// ── Admin Zone ────────────────────────────────────────────────────────────────
