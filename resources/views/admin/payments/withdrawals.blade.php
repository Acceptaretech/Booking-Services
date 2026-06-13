@extends('layouts.admin.app')
@section('title','Withdrawal Requests')
@section('page_title','Withdrawal Requests')
@section('content')
<div class="card overflow-hidden">
  <table class="data-table w-full">
    <thead><tr><th>Bank Name</th><th>Provider</th><th>Amount</th><th>Payment Type</th><th>Date</th><th>Status</th><th>Action</th></tr></thead>
    <tbody>
    @forelse($withdrawals as $w)
    <tr>
      <td><p class="font-medium text-sm text-gray-800 dark:text-gray-200">{{ $w->bank_name }}</p><p class="text-xs text-gray-400">{{ $w->account_number }}</p></td>
      <td><div class="flex items-center gap-2"><img src="{{ $w->user->profile_image_url }}" class="w-7 h-7 rounded-full">
      <div><p class="text-xs font-medium">{{ $w->user->full_name }}</p><p class="text-xs text-gray-400">{{ $w->user->email }}</p></div></div></td>
      <td><span class="font-bold text-lg text-gray-800 dark:text-white">${{ number_format($w->amount,2) }}</span></td>
      <td><span class="badge badge-info capitalize">{{ $w->payment_type }}</span></td>
      <td><span class="text-xs text-gray-500">{{ $w->created_at->format('M d, Y') }}</span></td>
      <td>@php $sc=['pending'=>'badge-warning','approved'=>'badge-success','rejected'=>'badge-danger']; @endphp
      <span class="badge {{ $sc[$w->status] }}">{{ ucfirst($w->status) }}</span></td>
      <td>
        @if($w->status==='pending')
        <form method="POST" action="{{ route('admin.withdrawals.approve',$w) }}">@csrf @method('PATCH')
        <button type="submit" class="btn-primary text-xs py-1.5 px-3"><i class="fas fa-check"></i>Approve</button></form>
        @else
        <span class="text-xs text-gray-400">—</span>
        @endif
      </td>
    </tr>
    @empty
    <tr><td colspan="7" class="text-center py-12 text-gray-400"><i class="fas fa-money-bill-wave text-4xl text-gray-200 mb-2 block"></i><p>No withdrawal requests</p></td></tr>
    @endforelse
    </tbody>
  </table>
  <div class="px-5 py-3 border-t border-gray-100 dark:border-gray-700">{{ $withdrawals->withQueryString()->links() }}</div>
</div>
@endsection
