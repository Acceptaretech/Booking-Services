@extends('layouts.admin.app')
@section('title','Add Tax')
@section('page_title','Add New Tax')
@section('content')
<a href="{{ route('admin.taxes.index') }}" class="btn-secondary text-xs py-2 mb-5 inline-flex"><i class="fas fa-arrow-left"></i>Back</a>
<div class="card p-6 max-w-md">
  <form method="POST" action="{{ route('admin.taxes.store') }}">@csrf
  <div class="mb-4"><label class="form-label">Tax Title <span class="text-red-500">*</span></label><input name="title" value="{{ old('title') }}" required placeholder="e.g. GST, VAT" class="form-input"></div>
  <div class="grid grid-cols-2 gap-4 mb-4">
    <div><label class="form-label">Value <span class="text-red-500">*</span></label><input type="number" name="value" value="{{ old('value') }}" required min="0" step="0.01" placeholder="e.g. 18" class="form-input"></div>
    <div><label class="form-label">Type</label><select name="type" class="form-select"><option value="percent">Percent (%)</option><option value="fixed">Fixed ($)</option></select></div>
  </div>
  <div class="mb-5"><label class="form-label">Status</label><select name="status" class="form-select w-36"><option value="active">Active</option><option value="inactive">Inactive</option></select></div>
  <div class="flex gap-3"><button type="submit" class="btn-primary"><i class="fas fa-save"></i>Save Tax</button><a href="{{ route('admin.taxes.index') }}" class="btn-secondary">Cancel</a></div>
  </form>
</div>
@endsection
