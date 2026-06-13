@extends('layouts.admin.app')
@section('title','Edit Zone')
@section('page_title','Edit Zone')
@section('content')
<a href="{{ route('admin.zones.index') }}" class="btn-secondary text-xs py-2 mb-5 inline-flex"><i class="fas fa-arrow-left"></i>Back</a>
<div class="card p-6 max-w-lg">
  <form method="POST" action="{{ route('admin.zones.update',$zone) }}">@csrf @method('PUT')
  <div class="mb-4"><label class="form-label">Zone Name <span class="text-red-500">*</span></label>
  <input name="name" value="{{ old('name',$zone->name) }}" required class="form-input"></div>
  <div class="grid grid-cols-2 gap-4 mb-4">
    <div><label class="form-label">Country</label><input name="country" value="{{ old('country',$zone->country) }}" class="form-input"></div>
    <div><label class="form-label">State</label><input name="state" value="{{ old('state',$zone->state) }}" class="form-input"></div>
  </div>
  <div class="mb-5"><label class="form-label">City</label><input name="city" value="{{ old('city',$zone->city) }}" class="form-input"></div>
  <div class="mb-6"><label class="form-label">Status</label>
  <select name="status" class="form-select w-40"><option value="active" {{ $zone->status==='active'?'selected':'' }}>Active</option><option value="inactive" {{ $zone->status==='inactive'?'selected':'' }}>Inactive</option></select></div>
  <div class="flex gap-3"><button type="submit" class="btn-primary"><i class="fas fa-save"></i>Update Zone</button><a href="{{ route('admin.zones.index') }}" class="btn-secondary">Cancel</a></div>
  </form>
</div>
@endsection
