@extends('layouts.admin.app')
@section('title','Banners')
@section('page_title','Promotional Banners')
@section('content')
<div class="flex gap-2 mb-5">
  @foreach([''=>'All','pending'=>'Pending','accepted'=>'Approved','rejected'=>'Rejected'] as $val => $label)
  <a href="{{ request()->fullUrlWithQuery(['status'=>$val]) }}"
     class="px-4 py-1.5 rounded-full text-xs font-medium border transition-all {{ request('status')===$val?'bg-primary-600 text-white border-primary-600':'border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300' }}">
    {{ $label }}
  </a>
  @endforeach
</div>
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
  @forelse($banners as $b)
  <div class="card overflow-hidden">
    <div class="relative h-36 overflow-hidden bg-gray-100 dark:bg-gray-700">
      <img src="{{ asset('storage/'.$b->image) }}" class="w-full h-full object-cover">
      @php $sc=['pending'=>'badge-warning','accepted'=>'badge-success','rejected'=>'badge-danger']; @endphp
      <span class="absolute top-2 right-2 badge {{ $sc[$b->status]??'badge-pending' }}">{{ ucfirst($b->status) }}</span>
    </div>
    <div class="p-4">
      <div class="flex items-center gap-2 mb-2">
        <img src="{{ $b->user->profile_image_url }}" class="w-6 h-6 rounded-full">
        <span class="text-xs text-gray-500">{{ $b->user->full_name }}</span>
      </div>
      <p class="text-xs text-gray-500 mb-2">
        {{ \Carbon\Carbon::parse($b->start_date)->format('M d') }} — {{ \Carbon\Carbon::parse($b->end_date)->format('M d, Y') }}
        · ${{ number_format($b->total_amount,2) }}
      </p>
      <div class="flex gap-2">
        @if($b->status==='pending')
        <form method="POST" action="{{ route('admin.banners.approve',$b) }}" class="flex-1">@csrf @method('PATCH')
        <button class="btn-primary w-full justify-center text-xs py-1.5"><i class="fas fa-check"></i>Approve</button></form>
        <form method="POST" action="{{ route('admin.banners.reject',$b) }}">@csrf @method('PATCH')
        <button class="btn-danger text-xs py-1.5 px-3"><i class="fas fa-times"></i></button></form>
        @else
        <span class="text-xs text-gray-400 flex items-center">Decision made</span>
        @endif
      </div>
    </div>
  </div>
  @empty
  <div class="col-span-3 card p-14 text-center text-gray-400">
    <i class="fas fa-images text-5xl text-gray-200 mb-3 block"></i>
    <p class="font-medium text-gray-500">No banners submitted</p>
  </div>
  @endforelse
</div>
<div class="mt-5">{{ $banners->withQueryString()->links() }}</div>
@endsection
