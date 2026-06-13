@extends('layouts.admin.app')
@section('title','Ratings')
@section('page_title','Ratings & Reviews')
@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
  @php
    $avgRating = \App\Models\Review::avg('rating') ?? 0;
    $totalReviews = \App\Models\Review::count();
    $fiveStars = \App\Models\Review::where('rating',5)->count();
  @endphp
  <div class="card p-5 flex items-center gap-4">
    <div class="w-12 h-12 rounded-2xl bg-yellow-100 flex items-center justify-center"><i class="fas fa-star text-yellow-500 text-xl"></i></div>
    <div><p class="text-2xl font-bold text-gray-800 dark:text-white">{{ number_format($avgRating,1) }}</p><p class="text-xs text-gray-400">Average Rating</p></div>
  </div>
  <div class="card p-5 flex items-center gap-4">
    <div class="w-12 h-12 rounded-2xl bg-primary-100 flex items-center justify-center"><i class="fas fa-comments text-primary-500 text-xl"></i></div>
    <div><p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $totalReviews }}</p><p class="text-xs text-gray-400">Total Reviews</p></div>
  </div>
  <div class="card p-5 flex items-center gap-4">
    <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center"><i class="fas fa-thumbs-up text-emerald-500 text-xl"></i></div>
    <div><p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $fiveStars }}</p><p class="text-xs text-gray-400">5-Star Reviews</p></div>
  </div>
</div>
<div class="card overflow-hidden">
  <table class="data-table w-full">
    <thead><tr><th>Customer</th><th>Service</th><th>Provider</th><th>Handyman</th><th>Rating</th><th>Review</th><th>Date</th></tr></thead>
    <tbody>
    @forelse($reviews as $r)
    <tr>
      <td><div class="flex items-center gap-2"><img src="{{ $r->customer->profile_image_url }}" class="w-7 h-7 rounded-full">
      <span class="text-xs font-medium">{{ $r->customer->full_name }}</span></div></td>
      <td><span class="text-xs text-gray-600 dark:text-gray-400">{{ Str::limit($r->service->name,20) }}</span></td>
      <td><span class="text-xs text-gray-500">{{ $r->provider->full_name }}</span></td>
      <td><span class="text-xs text-gray-500">{{ $r->handyman?->full_name ?? '—' }}</span></td>
      <td>
        <div class="flex items-center gap-0.5">
          @for($i=1;$i<=5;$i++)<i class="fas fa-star text-xs {{ $i<=$r->rating?'text-yellow-400':'text-gray-300' }}"></i>@endfor
          <span class="text-xs text-gray-500 ml-1">{{ $r->rating }}</span>
        </div>
      </td>
      <td><p class="text-xs text-gray-500 max-w-xs line-clamp-2">{{ $r->review ?? '—' }}</p></td>
      <td><span class="text-xs text-gray-400">{{ $r->created_at->format('M d, Y') }}</span></td>
    </tr>
    @empty
    <tr><td colspan="7" class="text-center py-12 text-gray-400"><i class="fas fa-star text-4xl text-gray-200 mb-2 block"></i><p>No reviews yet</p></td></tr>
    @endforelse
    </tbody>
  </table>
  <div class="px-5 py-3 border-t border-gray-100 dark:border-gray-700">{{ $reviews->withQueryString()->links() }}</div>
</div>
@endsection
