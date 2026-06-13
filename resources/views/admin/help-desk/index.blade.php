@extends('layouts.admin.app')
@section('title','Help Desk')
@section('page_title','Help Desk')
@section('content')
<div class="flex items-center justify-between mb-5">
  <div class="flex gap-2">
    @foreach([''=>'All','open'=>'Open','in_progress'=>'In Progress','closed'=>'Closed'] as $val => $label)
    <a href="{{ request()->fullUrlWithQuery(['status'=>$val]) }}"
       class="px-4 py-1.5 rounded-full text-xs font-medium border transition-all {{ request('status')===$val?'bg-primary-600 text-white border-primary-600':'border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 hover:border-primary-400' }}">
      {{ $label }}
    </a>
    @endforeach
  </div>
  <a href="{{ route('admin.help-desk.create') }}" class="btn-primary text-xs"><i class="fas fa-plus"></i>New Ticket</a>
</div>
<div class="card overflow-hidden">
  <table class="data-table w-full">
    <thead><tr><th>Ticket</th><th>User</th><th>Role</th><th>Subject</th><th>Date & Time</th><th>Mode</th><th>Status</th><th>Action</th></tr></thead>
    <tbody>
    @forelse($tickets as $t)
    <tr>
      <td><span class="font-semibold text-primary-600">#{{ $t->id }}</span></td>
      <td><div class="flex items-center gap-2"><img src="{{ $t->user->profile_image_url }}" class="w-7 h-7 rounded-full">
      <div><p class="text-xs font-medium">{{ $t->user->full_name }}</p><p class="text-xs text-gray-400">{{ $t->user->email }}</p></div></div></td>
      <td><span class="badge badge-info capitalize">{{ $t->role }}</span></td>
      <td><p class="text-xs text-gray-700 dark:text-gray-300 font-medium max-w-xs line-clamp-1">{{ $t->subject }}</p></td>
      <td><p class="text-xs text-gray-500">{{ $t->created_at->format('M d, Y') }}</p><p class="text-xs text-gray-400">{{ $t->created_at->format('g:i A') }}</p></td>
      <td><span class="badge badge-pending capitalize">{{ $t->mode }}</span></td>
      <td>@php $sc=['open'=>'badge-warning','in_progress'=>'badge-info','closed'=>'badge-success']; @endphp
      <span class="badge {{ $sc[$t->status]??'badge-pending' }}">{{ ucwords(str_replace('_',' ',$t->status)) }}</span></td>
      <td>
        <div class="flex items-center gap-1">
          <a href="{{ route('admin.help-desk.show',$t) }}" class="w-7 h-7 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600 hover:bg-blue-100"><i class="fas fa-eye text-xs"></i></a>
          <form method="POST" action="{{ route('admin.help-desk.destroy',$t) }}" id="del-hd-{{ $t->id }}">@csrf @method('DELETE')
          <button type="button" onclick="confirmDelete('del-hd-{{ $t->id }}')" class="w-7 h-7 rounded-lg bg-red-50 dark:bg-red-900/20 flex items-center justify-center text-red-600 hover:bg-red-100"><i class="fas fa-trash text-xs"></i></button></form>
        </div>
      </td>
    </tr>
    @empty
    <tr><td colspan="8" class="text-center py-12 text-gray-400"><i class="fas fa-headset text-4xl text-gray-200 mb-2 block"></i><p>No tickets found</p></td></tr>
    @endforelse
    </tbody>
  </table>
  <div class="px-5 py-3 border-t border-gray-100 dark:border-gray-700">{{ $tickets->withQueryString()->links() }}</div>
</div>
@endsection
