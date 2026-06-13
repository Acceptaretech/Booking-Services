@extends('layouts.admin.app')
@section('title','Edit Tax')
@section('page_title','Edit Tax')
@section('content')
<a href="{{ route('admin.taxes.index') }}" class="btn-secondary text-xs py-2 mb-5 inline-flex"><i class="fas fa-arrow-left"></i>Back</a>
<div class="card p-6 max-w-md">
  <form method="POST" action="{{ route('admin.taxes.update',$tax) }}">@csrf @method('PUT')
  <div class="mb-4"><label class="form-label">Tax Title</label><input name="title" value="{{ old('title',$tax->title) }}" required class="form-input"></div>
  <div class="grid grid-cols-2 gap-4 mb-4">
    <div><label class="form-label">Value</label><input type="number" name="value" value="{{ old('value',$tax->value) }}" required min="0" step="0.01" class="form-input"></div>
    <div><label class="form-label">Type</label><select name="type" class="form-select"><option value="percent" {{ $tax->type==='percent'?'selected':'' }}>Percent (%)</option><option value="fixed" {{ $tax->type==='fixed'?'selected':'' }}>Fixed ($)</option></select></div>
  </div>
  <div class="mb-5"><label class="form-label">Status</label><select name="status" class="form-select w-36"><option value="active" {{ $tax->status==='active'?'selected':'' }}>Active</option><option value="inactive" {{ $tax->status==='inactive'?'selected':'' }}>Inactive</option></select></div>
  <div class="flex gap-3"><button type="submit" class="btn-primary"><i class="fas fa-save"></i>Update Tax</button><a href="{{ route('admin.taxes.index') }}" class="btn-secondary">Cancel</a></div>
  </form>
</div>
@endsection
