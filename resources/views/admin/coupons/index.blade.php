
@extends('layouts.admin.app')
@section('title','Coupons')
@section('page_title','Coupon List')
@section('content')
<div class="flex items-center justify-between mb-5">
  <form method="GET" class="flex gap-2">
    <div class="relative"><i class="fas fa-search absolute left-3 top-2.5 text-gray-400 text-xs"></i>
    <input name="search" value="{{ request('search') }}" placeholder="Search coupons..." class="form-input pl-8 py-2 w-48 text-xs"></div>
  </form>
  <a href="{{ route('admin.coupons.create') }}" class="btn-primary text-xs"><i class="fas fa-plus"></i>New Coupon</a>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
  @forelse($coupons as $c)
  <div class="card p-5">
    <div class="flex items-start justify-between mb-3">
      <div class="bg-gradient-to-br from-primary-500 to-purple-600 text-white px-3 py-1.5 rounded-xl">
        <p class="font-bold text-base tracking-wider">{{ $c->code }}</p>
      </div>
      <div class="flex gap-1">
        <a href="{{ route('admin.coupons.edit',$c) }}" class="w-7 h-7 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600 hover:bg-blue-100"><i class="fas fa-edit text-xs"></i></a>
        <form method="POST" action="{{ route('admin.coupons.destroy',$c) }}" id="del-coup-{{ $c->id }}">@csrf @method('DELETE')
        <button type="button" onclick="confirmDelete('del-coup-{{ $c->id }}')" class="w-7 h-7 rounded-lg bg-red-50 dark:bg-red-900/20 flex items-center justify-center text-red-600 hover:bg-red-100"><i class="fas fa-trash text-xs"></i></button></form>
      </div>
    </div>
    <div class="space-y-2 text-sm">
      <div class="flex justify-between"><span class="text-gray-500">Discount</span>
        <span class="font-semibold text-emerald-600">{{ $c->discount }}{{ $c->discount_type==='percent'?'%':' $' }} off</span></div>
      <div class="flex justify-between"><span class="text-gray-500">Min Amount</span><span class="font-medium">${{ $c->min_amount }}</span></div>
      <div class="flex justify-between"><span class="text-gray-500">Used / Limit</span><span class="font-medium">{{ $c->used_count }} / {{ $c->usage_limit ?? '∞' }}</span></div>
      <div class="flex justify-between"><span class="text-gray-500">Expires</span><span class="font-medium text-xs">{{ $c->end_date ? \Carbon\Carbon::parse($c->end_date)->format('M d, Y') : 'No expiry' }}</span></div>
    </div>
    <div class="mt-3 pt-3 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">
      <span class="badge {{ $c->status==='active'?'badge-success':'badge-pending' }}">{{ ucfirst($c->status) }}</span>
      <div class="w-full ml-3 bg-gray-100 dark:bg-gray-700 rounded-full h-1.5 overflow-hidden">
        @php $pct = $c->usage_limit ? min(100,round($c->used_count/$c->usage_limit*100)) : 0; @endphp
        <div class="h-full bg-primary-500 rounded-full" style="width:{{ $pct }}%"></div>
      </div>
    </div>
  </div>
  @empty<div class="col-span-3 card p-14 text-center text-gray-400"><i class="fas fa-ticket-alt text-4xl mb-3 block"></i><p>No coupons found</p><a href="{{ route('admin.coupons.create') }}" class="btn-primary text-xs mt-3 inline-flex"><i class="fas fa-plus"></i>Create First Coupon</a></div>
  @endforelse
</div>
<div class="mt-5">{{ $coupons->links() }}</div>
@endsection
