
@extends('layouts.admin.app')
@section('title','Customers')
@section('page_title','Customer List')
@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
  <form method="GET" class="flex gap-2">
    <div class="relative"><i class="fas fa-search absolute left-3 top-2.5 text-gray-400 text-xs"></i>
    <input name="search" value="{{ request('search') }}" placeholder="Search customers..." class="form-input pl-8 py-2 w-52 text-xs"></div>
  </form>
</div>
<div class="card overflow-hidden">
  <table class="data-table w-full">
    <thead><tr><th>Customer</th><th>Phone</th><th>Bookings</th><th>Joined</th><th>Status</th><th>Action</th></tr></thead>
    <tbody>
    @forelse($customers as $c)
    <tr>
      <td><div class="flex items-center gap-3"><img src="{{ $c->profile_image_url }}" class="w-9 h-9 rounded-xl object-cover flex-shrink-0">
      <div><p class="font-medium text-sm text-gray-800 dark:text-gray-200">{{ $c->full_name }}</p><p class="text-xs text-gray-400">{{ $c->email }}</p></div></div></td>
      <td><span class="text-sm text-gray-600 dark:text-gray-400">{{ $c->phone ?? '—' }}</span></td>
      <td><span class="badge badge-info">{{ $c->customer_bookings_count }} bookings</span></td>
      <td><span class="text-xs text-gray-500">{{ $c->created_at->format('M d, Y') }}</span></td>
      <td>
        <label class="relative inline-flex items-center cursor-pointer">
          <input type="checkbox" class="sr-only peer" {{ $c->status==='active'?'checked':'' }} onchange="toggleStatus('{{ route('admin.users.toggle',$c) }}',this)">
          <div class="w-9 h-5 bg-gray-300 rounded-full peer peer-checked:bg-primary-600 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-4"></div>
        </label>
      </td>
      <td>
        <form method="POST" action="{{ route('admin.users.destroy',$c) }}" id="del-cust-{{ $c->id }}">@csrf @method('DELETE')
        <button type="button" onclick="confirmDelete('del-cust-{{ $c->id }}')" class="w-7 h-7 rounded-lg bg-red-50 flex items-center justify-center text-red-600 hover:bg-red-100"><i class="fas fa-trash text-xs"></i></button></form>
      </td>
    </tr>
    @empty<tr><td colspan="6" class="text-center py-12 text-gray-400"><i class="fas fa-users text-4xl mb-2 block"></i>No customers found</td></tr>
    @endforelse
    </tbody>
  </table>
  <div class="px-5 py-3 border-t border-gray-100 dark:border-gray-700">{{ $customers->withQueryString()->links() }}</div>
</div>
@endsection
