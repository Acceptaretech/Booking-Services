<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\{Blog, Category, Service, User};
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories        = Category::active()->featured()->withCount('services')->orderBy('sort_order')->take(8)->get();
        $topRatedServices  = Service::active()->with(['provider','category'])->topRated()->take(8)->get();
        $featuredServices  = Service::active()->featured()->with(['provider','category'])->take(8)->get();
        $popularProviders  = User::providers()->active()->withCount('providerBookings')->orderByDesc('provider_bookings_count')->take(6)->get();
        $featuredProviders = User::providers()->active()->take(3)->get();

        return view('public.home.index', compact(
            'categories','topRatedServices','featuredServices','popularProviders','featuredProviders'
        ));
    }

    public function categories(Request $request)
    {
        $categories = Category::active()
            ->withCount('services')
            ->when($request->search, fn($q) => $q->where('name','like','%'.$request->search.'%'))
            ->paginate(12);

        return view('public.categories.index', compact('categories'));
    }

    public function services(Request $request)
    {
        $query = Service::active()->with(['provider','category','shop']);

        if ($request->filled('category_id'))  $query->where('category_id', $request->category_id);
        if ($request->filled('provider_id'))  $query->where('user_id', $request->provider_id);
        if ($request->filled('price_min'))    $query->where('price','>=',$request->price_min);
        if ($request->filled('price_max'))    $query->where('price','<=',$request->price_max);
        if ($request->filled('search'))       $query->where('name','like','%'.$request->search.'%');
        if ($request->filled('featured'))     $query->featured();

        match($request->sort) {
            'top_rated'    => $query->topRated(),
            'best_selling' => $query->bestSelling(),
            default        => $query->latest(),
        };

        $services   = $query->paginate(12);
        $categories = Category::active()->get();
        $providers  = User::providers()->active()->get();

        return view('public.services.index', compact('services','categories','providers'));
    }

    public function serviceDetail(\App\Models\Service $service)
    {
        $service->load(['provider','category','subCategory','shop','faqs','addons','reviews.customer']);
        $relatedServices = Service::active()
            ->where('category_id', $service->category_id)
            ->where('id','!=',$service->id)
            ->with('provider')->take(4)->get();

        return view('public.services.show', compact('service','relatedServices'));
    }

    public function providers(Request $request)
    {
        $providers = User::providers()->active()
            ->withAvg('reviews','rating')
            ->withCount('services')
            ->when($request->search, fn($q) => $q->where('first_name','like','%'.$request->search.'%')
                ->orWhere('last_name','like','%'.$request->search.'%'))
            ->paginate(12);

        return view('public.providers.index', compact('providers'));
    }

    public function providerDetail(User $user)
    {
        abort_unless($user->isProvider(), 404);
        $user->load(['shops','services.category','reviews.customer']);
        return view('public.providers.show', compact('user'));
    }

    public function blogs(Request $request)
    {
        $blogs = Blog::where('status','published')
            ->with('author')
            ->when($request->search, fn($q) => $q->where('title','like','%'.$request->search.'%'))
            ->latest('published_at')
            ->paginate(12);

        return view('public.blogs.index', compact('blogs'));
    }

    public function blogDetail(Blog $blog)
    {
        abort_unless($blog->status === 'published', 404);
        $blog->increment('views');
        $blog->load('author');
        $related = Blog::where('status','published')->where('id','!=',$blog->id)->latest()->take(3)->get();
        return view('public.blogs.show', compact('blog','related'));
    }

    public function about()  { return view('public.about'); }
    public function contact(){ return view('public.contact'); }
}
