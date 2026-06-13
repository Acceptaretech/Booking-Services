@extends('layouts.admin.app')
@section('title','Edit Sub-Category')
@section('page_title','Edit Sub-Category')
@section('content')
<div class="flex items-center gap-3 mb-5">
  <a href="{{ route('admin.sub-categories.index') }}" class="btn-secondary text-xs py-2"><i class="fas fa-arrow-left"></i>Back</a>
</div>
<div class="card p-6 max-w-xl">
  <form method="POST" action="{{ route('admin.sub-categories.update',$subCategory) }}" enctype="multipart/form-data">
  @csrf @method('PUT')
  <div class="mb-5">
    <label class="form-label">Parent Category <span class="text-red-500">*</span></label>
    <select name="category_id" required class="form-select">
      @foreach($categories as $cat)<option value="{{ $cat->id }}" {{ $subCategory->category_id==$cat->id?'selected':'' }}>{{ $cat->name }}</option>@endforeach
    </select>
  </div>
  <div class="mb-5">
    <label class="form-label">Sub-Category Name <span class="text-red-500">*</span></label>
    <input name="name" value="{{ old('name',$subCategory->name) }}" required class="form-input">
  </div>
  <div class="mb-5">
    <label class="form-label">Description</label>
    <textarea name="description" rows="3" class="form-input resize-none">{{ old('description',$subCategory->description) }}</textarea>
  </div>
  <div class="mb-5">
    <label class="form-label">Image</label>
    @if($subCategory->image)<img src="{{ asset('storage/'.$subCategory->image) }}" class="w-14 h-14 rounded-lg object-cover mb-2">@endif
    <input type="file" name="image" accept="image/*" class="form-input py-2">
  </div>
  <div class="mb-6">
    <label class="form-label">Status</label>
    <select name="status" class="form-select w-40">
      <option value="active" {{ $subCategory->status==='active'?'selected':'' }}>Active</option>
      <option value="inactive" {{ $subCategory->status==='inactive'?'selected':'' }}>Inactive</option>
    </select>
  </div>
  <div class="flex gap-3">
    <button type="submit" class="btn-primary"><i class="fas fa-save"></i>Update</button>
    <a href="{{ route('admin.sub-categories.index') }}" class="btn-secondary">Cancel</a>
  </div>
  </form>
</div>
@endsection
