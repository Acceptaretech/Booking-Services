
@extends('layouts.admin.app')
@section('title','Add Coupon')
@section('page_title','Create Coupon')
@section('content')
<div class="max-w-xl">
  <a href="{{ route('admin.coupons.index') }}" class="btn-secondary text-xs py-2 mb-5 inline-flex"><i class="fas fa-arrow-left"></i>Back</a>
  <div class="card p-6">
    <form method="POST" action="{{ route('admin.coupons.store') }}">@csrf
    <div class="mb-4"><label class="form-label">Coupon Code <span class="text-red-500">*</span></label>
    <div class="flex gap-2"><input name="code" value="{{ old('code') }}" required placeholder="e.g. SAVE20" class="form-input uppercase" style="letter-spacing:2px">
    <button type="button" onclick="document.querySelector('[name=code]').value=Math.random().toString(36).substr(2,8).toUpperCase()" class="btn-secondary text-xs px-3 whitespace-nowrap"><i class="fas fa-magic"></i>Generate</button></div></div>
    <div class="grid grid-cols-2 gap-4 mb-4">
      <div><label class="form-label">Discount Type <span class="text-red-500">*</span></label>
      <select name="discount_type" class="form-select">
        <option value="percent">Percent (%)</option><option value="fixed">Fixed ($)</option>
      </select></div>
      <div><label class="form-label">Discount Value <span class="text-red-500">*</span></label>
      <input type="number" name="discount" value="{{ old('discount') }}" required min="0" step="0.01" placeholder="e.g. 20" class="form-input"></div>
    </div>
    <div class="grid grid-cols-2 gap-4 mb-4">
      <div><label class="form-label">Min Order Amount</label><input type="number" name="min_amount" value="{{ old('min_amount',0) }}" min="0" class="form-input"></div>
      <div><label class="form-label">Max Discount ($)</label><input type="number" name="max_discount" value="{{ old('max_discount') }}" min="0" class="form-input" placeholder="Optional"></div>
    </div>
    <div class="grid grid-cols-2 gap-4 mb-4">
      <div><label class="form-label">Usage Limit</label><input type="number" name="usage_limit" value="{{ old('usage_limit') }}" min="1" class="form-input" placeholder="Leave empty for unlimited"></div>
      <div><label class="form-label">Status</label>
      <select name="status" class="form-select"><option value="active">Active</option><option value="inactive">Inactive</option></select></div>
    </div>
    <div class="grid grid-cols-2 gap-4 mb-5">
      <div><label class="form-label">Start Date</label><input type="date" name="start_date" value="{{ old('start_date') }}" class="form-input"></div>
      <div><label class="form-label">End Date</label><input type="date" name="end_date" value="{{ old('end_date') }}" class="form-input"></div>
    </div>
    <div class="flex gap-3">
      <button type="submit" class="btn-primary"><i class="fas fa-save"></i>Create Coupon</button>
      <a href="{{ route('admin.coupons.index') }}" class="btn-secondary">Cancel</a>
    </div>
    </form>
  </div>
</div>
@endsection
