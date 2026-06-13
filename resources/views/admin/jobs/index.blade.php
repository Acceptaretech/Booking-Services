@extends('layouts.admin.app')
@section('title','Job Requests')
@section('page_title','Job Request List')
@section('content')
<div class="card overflow-hidden">
  <table class="data-table w-full">
    <thead><tr><th><input type="checkbox" class="rounded"></th><th>Title</th><th>Provider</th><th>Customer</th><th>Status</th><th>Price</th><th>Action</th></tr></thead>
    <tbody>
    @forelse($jobs as $job)
    <tr>
      <td><input type="checkbox" class="rounded"></td>
      <td>
        <div class="flex items-center gap-2">
          <div class="w-9 h-9 rounded-xl bg-primary-50 dark:bg-primary-900/20 flex items-center justify-center flex-shrink-0"><i class="fas fa-briefcase text-primary-500 text-sm"></i></div>
          <div><p class="font-medium text-sm text-gray-800 dark:text-gray-200">{{ $job->title }}</p>
          <p class="text-xs text-gray-400">{{ Str::limit($job->description,40) }}</p></div>
        </div>
      </td>
      <td><span class="text-xs text-gray-500">{{ $job->bids->first()?->provider->full_name ?? '—' }}</span></td>
      <td><div class="flex items-center gap-2"><img src="{{ $job->customer->profile_image_url }}" class="w-6 h-6 rounded-full">
      <span class="text-xs text-gray-600 dark:text-gray-400">{{ $job->customer->full_name }}</span></div></td>
      <td>@php $sc=['pending'=>'badge-warning','accepted'=>'badge-success','rejected'=>'badge-danger','completed'=>'badge-info']; @endphp
      <span class="badge {{ $sc[$job->status]??'badge-pending' }}">{{ ucfirst($job->status) }}</span></td>
      <td><span class="font-semibold text-primary-600">{{ $job->price ? '$'.number_format($job->price,2) : '—' }}</span></td>
      <td><span class="badge badge-info">{{ $job->bids->count() }} bids</span></td>
    </tr>
    @empty
    <tr><td colspan="7" class="text-center py-12 text-gray-400"><i class="fas fa-briefcase text-4xl text-gray-200 mb-2 block"></i><p>No job requests</p></td></tr>
    @endforelse
    </tbody>
  </table>
  <div class="px-5 py-3 border-t border-gray-100 dark:border-gray-700">{{ $jobs->withQueryString()->links() }}</div>
</div>
@endsection
