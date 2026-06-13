
@extends('layouts.admin.app')
@section('title','Edit Coupon')
@section('page_title','Edit Coupon')
@section('content')
<div class="max-w-xl">
  <a href="{{ route('admin.coupons.index') }}" class="btn-secondary text-xs py-2 mb-5 inline-flex"><i class="fas fa-arrow-left"></i>Back</a>
  <div class="card p-6">
    <form method="POST" action="{{ route('admin.coupons.update',$coupon) }}">@csrf @method('PUT')
    <div class="mb-4"><label class="form-label">Coupon Code</label>
    <input name="code" value="{{ old('code',$coupon->code) }}" required class="form-input uppercase" style="letter-spacing:2px"></div>
    <div class="grid grid-cols-2 gap-4 mb-4">
      <div><label class="form-label">Discount Type</label>
      <select name="discount_type" class="form-select">
        <option value="percent" {{ $coupon->discount_type==='percent'?'selected':'' }}>Percent (%)</option>
        <option value="fixed" {{ $coupon->discount_type==='fixed'?'selected':'' }}>Fixed ($)</option>
      </select></div>
      <div><label class="form-label">Discount Value</label>
      <input type="number" name="discount" value="{{ old('discount',$coupon->discount) }}" class="form-input"></div>
    </div>
    <div class="grid grid-cols-2 gap-4 mb-4">
      <div><label class="form-label">Min Amount</label><input type="number" name="min_amount" value="{{ old('min_amount',$coupon->min_amount) }}" class="form-input"></div>
      <div><label class="form-label">Usage Limit</label><input type="number" name="usage_limit" value="{{ old('usage_limit',$coupon->usage_limit) }}" class="form-input" placeholder="Unlimited"></div>
    </div>
    <div class="grid grid-cols-2 gap-4 mb-5">
      <div><label class="form-label">End Date</label><input type="date" name="end_date" value="{{ old('end_date',$coupon->end_date) }}" class="form-input"></div>
      <div><label class="form-label">Status</label>
      <select name="status" class="form-select">
        <option value="active" {{ $coupon->status==='active'?'selected':'' }}>Active</option>
        <option value="inactive" {{ $coupon->status==='inactive'?'selected':'' }}>Inactive</option>
      </select></div>
    </div>
    <div class="flex gap-3">
      <button type="submit" class="btn-primary"><i class="fas fa-save"></i>Update Coupon</button>
      <a href="{{ route('admin.coupons.index') }}" class="btn-secondary">Cancel</a>
    </div>
    </form>
  </div>
</div>
@endsection
