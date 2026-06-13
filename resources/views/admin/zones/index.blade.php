@extends('layouts.admin.app')
@section('title','Zones')
@section('page_title','Zone List')
@section('content')
<div class="flex items-center justify-between mb-5">
  <h2 class="text-sm text-gray-600 dark:text-gray-400">Manage service zones and locations</h2>
  <a href="{{ route('admin.zones.create') }}" class="btn-primary text-xs"><i class="fas fa-plus"></i>New Zone</a>
</div>
<div class="card overflow-hidden">
  <table class="data-table w-full">
    <thead><tr><th>Zone Name</th><th>Country</th><th>State</th><th>City</th><th>Providers</th><th>Status</th><th>Action</th></tr></thead>
    <tbody>
    @forelse($zones as $zone)
    <tr>
      <td><p class="font-semibold text-sm text-gray-800 dark:text-gray-200">{{ $zone->name }}</p></td>
      <td><span class="text-xs text-gray-500">{{ $zone->country ?? '—' }}</span></td>
      <td><span class="text-xs text-gray-500">{{ $zone->state ?? '—' }}</span></td>
      <td><span class="text-xs text-gray-500">{{ $zone->city ?? '—' }}</span></td>
      <td><span class="badge badge-info">{{ $zone->users_count ?? 0 }} users</span></td>
      <td><span class="badge {{ $zone->status==='active'?'badge-success':'badge-pending' }}">{{ ucfirst($zone->status) }}</span></td>
      <td>
        <div class="flex items-center gap-1">
          <a href="{{ route('admin.zones.edit',$zone) }}" class="w-7 h-7 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600 hover:bg-blue-100"><i class="fas fa-edit text-xs"></i></a>
          <form method="POST" action="{{ route('admin.zones.destroy',$zone) }}" id="del-z-{{ $zone->id }}">@csrf @method('DELETE')
          <button type="button" onclick="confirmDelete('del-z-{{ $zone->id }}')" class="w-7 h-7 rounded-lg bg-red-50 dark:bg-red-900/20 flex items-center justify-center text-red-600 hover:bg-red-100"><i class="fas fa-trash text-xs"></i></button></form>
        </div>
      </td>
    </tr>
    @empty
    <tr><td colspan="7" class="text-center py-12 text-gray-400">
      <i class="fas fa-map-marked-alt text-4xl text-gray-200 mb-2 block"></i>
      <p class="font-medium text-gray-500 mb-2">No zones yet</p>
      <a href="{{ route('admin.zones.create') }}" class="btn-primary text-xs"><i class="fas fa-plus"></i>Add Zone</a>
    </td></tr>
    @endforelse
    </tbody>
  </table>
  <div class="px-5 py-3 border-t border-gray-100 dark:border-gray-700">{{ $zones->links() }}</div>
</div>
@endsection
