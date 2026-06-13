<?php

namespace App\Services\Public;

use App\Models\{Blog, Category, Service, User};
use App\Services\Interfaces\HomeServiceInterface;
use Illuminate\Http\Request;

class HomeService implements HomeServiceInterface
{
    public function home()
    {
        return [
            'categories' => Category::active()->featured()->withCount('services')->orderBy('sort_order')->take(8)->get(),
            'top_rated_services' => Service::active()->with(['provider', 'category'])->topRated()->take(8)->get(),
            'featured_services' => Service::active()->featured()->with(['provider', 'category'])->take(8)->get(),
            'popular_providers' => User::providers()->active()->withCount('providerBookings')->orderByDesc('provider_bookings_count')->take(6)->get(),
            'featured_providers' => User::providers()->active()->take(3)->get(),
        ];
    }

    public function categories(Request $request)
    {
        return Category::active()
            ->withCount('services')
            ->when($request->search, fn($q) => $q->where('name', 'like', '%' . $request->search . '%'))
            ->orderBy('sort_order')
            ->paginate($request->per_page ?? 12);
    }

    public function services(Request $request)
    {
        $query = Service::active()->with(['provider', 'category', 'shop']);

        $query->when($request->category_id, fn($q) => $q->where('category_id', $request->category_id));
        $query->when($request->provider_id, fn($q) => $q->where('user_id', $request->provider_id));
        $query->when($request->price_min, fn($q) => $q->where('price', '>=', $request->price_min));
        $query->when($request->price_max, fn($q) => $q->where('price', '<=', $request->price_max));
        $query->when($request->search, fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));

        if ($request->filled('featured')) {
            $query->featured();
        }

        match ($request->sort) {
            'top_rated' => $query->topRated(),
            'best_selling' => $query->bestSelling(),
            default => $query->latest(),
        };

        return $query->paginate($request->per_page ?? 12);
    }

    public function serviceDetail($id)
    {
        $service = Service::active()
            ->with(['provider', 'category', 'subCategory', 'shop', 'faqs', 'addons', 'reviews.customer'])
            ->findOrFail($id);

        $relatedServices = Service::active()
            ->where('category_id', $service->category_id)
            ->where('id', '!=', $service->id)
            ->with('provider')
            ->take(4)
            ->get();

        return [
            'service' => $service,
            'related_services' => $relatedServices,
        ];
    }

    public function providers(Request $request)
    {
        return User::providers()->active()
            ->withAvg('reviews', 'rating')
            ->withCount('services')
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($sub) use ($request) {
                    $sub->where('first_name', 'like', '%' . $request->search . '%')
                        ->orWhere('last_name', 'like', '%' . $request->search . '%');
                });
            })
            ->paginate($request->per_page ?? 12);
    }

    public function providerDetail($id)
    {
        return User::providers()
            ->active()
            ->with(['shops', 'services.category', 'reviews.customer'])
            ->findOrFail($id);
    }

    public function blogs(Request $request)
    {
        return Blog::where('status', 'published')
            ->with('author')
            ->when($request->search, fn($q) => $q->where('title', 'like', '%' . $request->search . '%'))
            ->latest('published_at')
            ->paginate($request->per_page ?? 12);
    }

    public function blogDetail($id)
    {
        $blog = Blog::where('status', 'published')
            ->with('author')
            ->findOrFail($id);

        $blog->increment('views');

        $relatedBlogs = Blog::where('status', 'published')
            ->where('id', '!=', $blog->id)
            ->latest()
            ->take(3)
            ->get();

        return [
            'blog' => $blog,
            'related_blogs' => $relatedBlogs,
        ];
    }
}