@extends('layouts.admin.app')
@section('title','Ticket Detail')
@section('page_title','Ticket Detail')
@section('content')
<a href="{{ route('admin.help-desk.index') }}" class="btn-secondary text-xs py-2 mb-5 inline-flex"><i class="fas fa-arrow-left"></i>Back</a>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
  <div class="lg:col-span-2 card p-6">
    <div class="flex items-start justify-between mb-5">
      <div>
        <h2 class="font-bold text-gray-900 dark:text-white text-lg">{{ $helpDesk->subject }}</h2>
        <p class="text-xs text-gray-400 mt-1">Ticket #{{ $helpDesk->id }} · {{ $helpDesk->created_at->format('M d, Y g:i A') }}</p>
      </div>
      @php $sc=['open'=>'badge-warning','in_progress'=>'badge-info','closed'=>'badge-success']; @endphp
      <span class="badge {{ $sc[$helpDesk->status]??'badge-pending' }} text-sm px-3 py-1">{{ ucwords(str_replace('_',' ',$helpDesk->status)) }}</span>
    </div>
    <div class="bg-gray-50 dark:bg-gray-700/30 rounded-xl p-4 mb-5">
      <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">{{ $helpDesk->description }}</p>
    </div>
    @if($helpDesk->image)
    <div class="mb-5"><p class="text-xs text-gray-500 mb-2 font-medium">Attachment</p>
    <img src="{{ asset('storage/'.$helpDesk->image) }}" class="max-w-sm rounded-xl shadow"></div>
    @endif
    <form method="POST" action="{{ route('admin.help-desk.update',$helpDesk) }}">@csrf @method('PUT')
      <div class="flex gap-3">
        <select name="status" class="form-select w-40">
          <option value="open" {{ $helpDesk->status==='open'?'selected':'' }}>Open</option>
          <option value="in_progress" {{ $helpDesk->status==='in_progress'?'selected':'' }}>In Progress</option>
          <option value="closed" {{ $helpDesk->status==='closed'?'selected':'' }}>Closed</option>
        </select>
        <button type="submit" class="btn-primary text-xs"><i class="fas fa-check"></i>Update Status</button>
      </div>
    </form>
  </div>
  <div class="card p-5 h-fit">
    <h3 class="font-semibold text-sm text-gray-800 dark:text-white mb-4">Submitted By</h3>
    <div class="flex items-center gap-3 mb-4">
      <img src="{{ $helpDesk->user->profile_image_url }}" class="w-12 h-12 rounded-xl object-cover">
      <div><p class="font-semibold text-sm text-gray-800 dark:text-gray-200">{{ $helpDesk->user->full_name }}</p>
      <p class="text-xs text-gray-400">{{ $helpDesk->user->email }}</p>
      <span class="badge badge-info capitalize text-xs mt-1">{{ $helpDesk->role }}</span></div>
    </div>
    <div class="space-y-2 text-xs text-gray-500">
      <p>Mode: <span class="text-gray-700 dark:text-gray-300 font-medium capitalize">{{ $helpDesk->mode }}</span></p>
      <p>Created: <span class="text-gray-700 dark:text-gray-300">{{ $helpDesk->created_at->diffForHumans() }}</span></p>
    </div>
  </div>
</div>
@endsection
