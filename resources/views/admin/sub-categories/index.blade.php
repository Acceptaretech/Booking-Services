@extends('layouts.admin.app')
@section('title','Sub Categories')
@section('page_title','Sub Category List')
@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
  <form method="GET" class="flex gap-2">
    <div class="relative"><i class="fas fa-search absolute left-3 top-2.5 text-gray-400 text-xs"></i>
    <input name="search" value="{{ request('search') }}" placeholder="Search sub-categories…" class="form-input pl-8 py-2 w-52 text-xs"></div>
    <button class="btn-secondary text-xs py-2"><i class="fas fa-search"></i></button>
  </form>
  <a href="{{ route('admin.sub-categories.create') }}" class="btn-primary text-xs"><i class="fas fa-plus"></i>New Sub-Category</a>
</div>
<div class="card overflow-hidden">
  <table class="data-table w-full">
    <thead><tr>
      <th class="w-8"><input type="checkbox" class="rounded"></th>
      <th>Name</th><th>Category</th><th>Status</th><th>Action</th>
    </tr></thead>
    <tbody>
    @forelse($subs as $sub)
    <tr>
      <td><input type="checkbox" class="rounded" value="{{ $sub->id }}"></td>
      <td>
        <div class="flex items-center gap-3">
          @if($sub->image)
            <img src="{{ asset('storage/'.$sub->image) }}" class="w-9 h-9 rounded-lg object-cover flex-shrink-0">
          @else
            <div class="w-9 h-9 rounded-lg bg-purple-50 dark:bg-purple-900/20 flex items-center justify-center flex-shrink-0">
              <i class="fas fa-sitemap text-purple-500 text-xs"></i>
            </div>
          @endif
          <p class="font-medium text-sm text-gray-800 dark:text-gray-200">{{ $sub->name }}</p>
        </div>
      </td>
      <td><span class="badge badge-info">{{ $sub->category->name }}</span></td>
      <td>
        <label class="relative inline-flex items-center cursor-pointer">
          <input type="checkbox" class="sr-only peer" {{ $sub->status==='active'?'checked':'' }}>
          <div class="w-9 h-5 bg-gray-200 rounded-full peer peer-checked:bg-primary-600
                      after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white
                      after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-4"></div>
        </label>
      </td>
      <td>
        <div class="flex items-center gap-1">
          <a href="{{ route('admin.sub-categories.edit',$sub) }}" class="w-7 h-7 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600 hover:bg-blue-100">
            <i class="fas fa-edit text-xs"></i></a>
          <form method="POST" action="{{ route('admin.sub-categories.destroy',$sub) }}" id="del-sub-{{ $sub->id }}">
            @csrf @method('DELETE')
            <button type="button" onclick="confirmDelete('del-sub-{{ $sub->id }}')"
                    class="w-7 h-7 rounded-lg bg-red-50 dark:bg-red-900/20 flex items-center justify-center text-red-600 hover:bg-red-100">
              <i class="fas fa-trash text-xs"></i></button>
          </form>
        </div>
      </td>
    </tr>
    @empty
    <tr><td colspan="5" class="text-center py-12 text-gray-400">
      <i class="fas fa-sitemap text-4xl text-gray-200 mb-2 block"></i>
      <p class="font-medium text-gray-500 mb-2">No sub-categories yet</p>
      <a href="{{ route('admin.sub-categories.create') }}" class="btn-primary text-xs"><i class="fas fa-plus"></i>Add Sub-Category</a>
    </td></tr>
    @endforelse
    </tbody>
  </table>
  <div class="px-5 py-3 border-t border-gray-100 dark:border-gray-700">{{ $subs->withQueryString()->links() }}</div>
</div>
@endsection
