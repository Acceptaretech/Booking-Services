<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Service;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $reviews = Review::with(['booking', 'service', 'provider', 'handyman'])
            ->where('customer_id', auth()->id())
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('review', 'like', "%{$search}%")
                        ->orWhereHas('service', function ($service) use ($search) {
                            $service->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('provider', function ($provider) use ($search) {
                            $provider->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        })
                        ->orWhereHas('handyman', function ($handyman) use ($search) {
                            $handyman->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->when($request->filled('rating'), function ($query) use ($request) {
                $query->where('rating', $request->rating);
            })
            ->latest()
            ->paginate($request->entries ?? 10)
            ->withQueryString();

        return view('customer.reviews.index', compact('reviews'));
    }

    public function show(Review $review)
    {
        abort_if($review->customer_id != auth()->id(), 403);

        $review->load(['booking', 'service', 'provider', 'handyman']);

        return view('customer.reviews.show', compact('review'));
    }

    public function destroy(Review $review)
    {
        abort_if($review->customer_id != auth()->id(), 403);

        $serviceId = $review->service_id;

        $review->delete();

        $this->updateServiceRating($serviceId);

        return redirect()
            ->route('customer.reviews')
            ->with('success', 'Review deleted successfully.');
    }

    private function updateServiceRating($serviceId): void
    {
        if (!$serviceId) {
            return;
        }

        $service = Service::find($serviceId);

        if (!$service) {
            return;
        }

        $avgRating = Review::where('service_id', $serviceId)
            ->where('status', 'active')
            ->avg('rating');

        $totalReviews = Review::where('service_id', $serviceId)
            ->where('status', 'active')
            ->count();

        $service->update([
            'avg_rating' => round($avgRating ?? 0, 2),
            'total_reviews' => $totalReviews,
        ]);
    }
}