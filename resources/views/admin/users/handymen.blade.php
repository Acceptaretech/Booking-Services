@extends('layouts.admin.app')
@section('title','Handymen')
@section('page_title','Handyman List')
@section('content')
<div class="card overflow-hidden">
  <table class="data-table w-full">
    <thead><tr><th>Handyman</th><th>Provider</th><th>Zone</th><th>Phone</th><th>Bookings</th><th>Status</th><th>Action</th></tr></thead>
    <tbody>
    @forelse($handymen as $h)
    <tr>
      <td><div class="flex items-center gap-3"><img src="{{ $h->profile_image_url }}" class="w-9 h-9 rounded-xl object-cover flex-shrink-0">
      <div><p class="font-medium text-sm text-gray-800 dark:text-gray-200">{{ $h->full_name }}</p><p class="text-xs text-gray-400">{{ $h->email }}</p></div></div></td>
      <td><span class="text-xs text-gray-500">{{ $h->zone?->name ?? '—' }}</span></td>
      <td><span class="badge badge-info">{{ $h->zone?->name ?? '—' }}</span></td>
      <td><span class="text-xs text-gray-500">{{ $h->phone ?? '—' }}</span></td>
      <td><span class="badge badge-pending">{{ $h->handyman_bookings_count ?? 0 }}</span></td>
      <td>
        <label class="relative inline-flex items-center cursor-pointer">
          <input type="checkbox" class="sr-only peer" {{ $h->status==='active'?'checked':'' }} onchange="toggleStatus('{{ route('admin.users.toggle',$h) }}',this)">
          <div class="w-9 h-5 bg-gray-200 rounded-full peer peer-checked:bg-primary-600 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-4"></div>
        </label>
      </td>
      <td>
        <form method="POST" action="{{ route('admin.users.destroy',$h) }}" id="del-hman-{{ $h->id }}">@csrf @method('DELETE')
        <button type="button" onclick="confirmDelete('del-hman-{{ $h->id }}')" class="w-7 h-7 rounded-lg bg-red-50 dark:bg-red-900/20 flex items-center justify-center text-red-600 hover:bg-red-100"><i class="fas fa-trash text-xs"></i></button></form>
      </td>
    </tr>
    @empty
    <tr><td colspan="7" class="text-center py-12 text-gray-400"><i class="fas fa-hard-hat text-4xl text-gray-200 mb-2 block"></i><p>No handymen found</p></td></tr>
    @endforelse
    </tbody>
  </table>
  <div class="px-5 py-3 border-t border-gray-100 dark:border-gray-700">{{ $handymen->withQueryString()->links() }}</div>
</div>
@endsection
