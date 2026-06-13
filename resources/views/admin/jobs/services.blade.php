@extends('layouts.admin.app')
@section('title','Job Service List')
@section('page_title','Job Service List')
@section('content')
<div class="card overflow-hidden">
  <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
    <h3 class="font-semibold text-sm text-gray-800 dark:text-white">All Services Available for Jobs</h3>
    <form method="GET" class="flex gap-2">
      <div class="relative"><i class="fas fa-search absolute left-3 top-2.5 text-gray-400 text-xs"></i>
      <input name="search" value="{{ request('search') }}" placeholder="Search…" class="form-input pl-8 py-2 w-44 text-xs"></div>
    </form>
  </div>
  <table class="data-table w-full">
    <thead><tr><th>Service</th><th>Provider</th><th>Category</th><th>Price</th><th>Bookings</th><th>Status</th></tr></thead>
    <tbody>
    @forelse($services as $s)
    <tr>
      <td><div class="flex items-center gap-2">
        @if($s->image)<img src="{{ asset('storage/'.$s->image) }}" class="w-8 h-8 rounded-lg object-cover">@endif
        <span class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $s->name }}</span>
      </div></td>
      <td><span class="text-xs text-gray-500">{{ $s->provider->full_name }}</span></td>
      <td><span class="badge badge-info">{{ $s->category->name }}</span></td>
      <td><span class="font-semibold text-primary-600">${{ number_format($s->price,2) }}</span></td>
      <td><span class="badge badge-pending">{{ $s->total_bookings }}</span></td>
      <td><span class="badge {{ $s->status==='active'?'badge-success':'badge-pending' }}">{{ ucfirst($s->status) }}</span></td>
    </tr>
    @empty
    <tr><td colspan="6" class="text-center py-10 text-gray-400">No services found</td></tr>
    @endforelse
    </tbody>
  </table>
  <div class="px-5 py-3 border-t border-gray-100 dark:border-gray-700">{{ $services->withQueryString()->links() }}</div>
</div>
@endsection
