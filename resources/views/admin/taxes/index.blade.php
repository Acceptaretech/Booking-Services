@extends('layouts.admin.app')
@section('title','Taxes')
@section('page_title','Tax List')
@section('content')
<div class="flex items-center justify-between mb-5">
  <p class="text-sm text-gray-500">Configure tax rates applied to bookings</p>
  <a href="{{ route('admin.taxes.create') }}" class="btn-primary text-xs"><i class="fas fa-plus"></i>New Tax</a>
</div>
<div class="card overflow-hidden">
  <table class="data-table w-full">
    <thead><tr><th>Title</th><th>Value</th><th>Type</th><th>Status</th><th>Action</th></tr></thead>
    <tbody>
    @forelse($taxes as $tax)
    <tr>
      <td><p class="font-semibold text-sm text-gray-800 dark:text-gray-200">{{ $tax->title }}</p></td>
      <td><span class="font-bold text-primary-600 text-lg">{{ $tax->value }}{{ $tax->type==='percent'?'%':' $' }}</span></td>
      <td><span class="badge badge-info capitalize">{{ $tax->type }}</span></td>
      <td><span class="badge {{ $tax->status==='active'?'badge-success':'badge-pending' }}">{{ ucfirst($tax->status) }}</span></td>
      <td>
        <div class="flex items-center gap-1">
          <a href="{{ route('admin.taxes.edit',$tax) }}" class="w-7 h-7 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600 hover:bg-blue-100"><i class="fas fa-edit text-xs"></i></a>
          <form method="POST" action="{{ route('admin.taxes.destroy',$tax) }}" id="del-tx-{{ $tax->id }}">@csrf @method('DELETE')
          <button type="button" onclick="confirmDelete('del-tx-{{ $tax->id }}')" class="w-7 h-7 rounded-lg bg-red-50 dark:bg-red-900/20 flex items-center justify-center text-red-600 hover:bg-red-100"><i class="fas fa-trash text-xs"></i></button></form>
        </div>
      </td>
    </tr>
    @empty
    <tr><td colspan="5" class="text-center py-12 text-gray-400"><i class="fas fa-receipt text-4xl text-gray-200 mb-2 block"></i><p class="mb-2">No taxes configured</p><a href="{{ route('admin.taxes.create') }}" class="btn-primary text-xs"><i class="fas fa-plus"></i>Add Tax</a></td></tr>
    @endforelse
    </tbody>
  </table>
</div>
@endsection
