
@extends('layouts.admin.app')
@section('title','Provider Detail')
@section('page_title','Provider Detail')
@section('content')
<div class="flex items-center gap-3 mb-5">
  <a href="{{ route('admin.providers.index') }}" class="btn-secondary text-xs py-2"><i class="fas fa-arrow-left"></i>Back</a>
</div>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
  <div class="space-y-5">
    <div class="card p-6 text-center">
      <img src="{{ $user->profile_image_url }}" class="w-20 h-20 rounded-2xl object-cover mx-auto mb-3">
      <h2 class="font-bold text-gray-900 dark:text-white">{{ $user->full_name }}</h2>
      <p class="text-sm text-gray-400">{{ $user->designation ?? 'Provider' }}</p>
      <p class="text-xs text-gray-400 mt-1">{{ $user->email }}</p>
      @php $sc=['active'=>'badge-success','pending'=>'badge-warning','rejected'=>'badge-danger']; @endphp
      <div class="mt-3"><span class="badge {{ $sc[$user->status]??'badge-pending' }}">{{ ucfirst($user->status) }}</span></div>
      @if($user->status==='pending')
      <div class="flex gap-2 mt-4">
        <form method="POST" action="{{ route('admin.providers.approve',$user) }}" class="flex-1">@csrf @method('PATCH')
        <button class="btn-primary w-full justify-center text-xs py-2"><i class="fas fa-check"></i>Approve</button></form>
        <form method="POST" action="{{ route('admin.providers.reject',$user) }}" class="flex-1">@csrf @method('PATCH')
        <button class="btn-danger w-full justify-center text-xs py-2"><i class="fas fa-times"></i>Reject</button></form>
      </div>
      @endif
    </div>
    <div class="card p-5">
      <h3 class="font-semibold text-sm text-gray-800 dark:text-white mb-4">Commission Setting</h3>
      <form method="POST" action="{{ route('admin.providers.commission',$user) }}">@csrf
        <div class="mb-3"><label class="form-label text-xs">Commission Value</label>
        <input type="number" name="commission_value" value="{{ $user->commissionSetting?->commission_value ?? 10 }}" min="0" max="100" step="0.01" class="form-input"></div>
        <div class="mb-3"><label class="form-label text-xs">Commission Type</label>
        <select name="commission_type" class="form-select">
          <option value="percent" {{ ($user->commissionSetting?->commission_type==='percent')?'selected':'' }}>Percent (%)</option>
          <option value="fixed" {{ ($user->commissionSetting?->commission_type==='fixed')?'selected':'' }}>Fixed ($)</option>
        </select></div>
        <button class="btn-primary w-full justify-center text-xs py-2"><i class="fas fa-save"></i>Save Commission</button>
      </form>
    </div>
    @if($user->document)
    <div class="card p-5">
      <h3 class="font-semibold text-sm text-gray-800 dark:text-white mb-4">KYC Documents</h3>
      @foreach(['passport'=>'Passport','aadhar_card'=>'Aadhar Card','pan_card'=>'PAN Card','driving_licence'=>'Driving Licence','voting_card'=>'Voting Card'] as $field => $label)
      @if($user->document->$field)
      <div class="mb-2"><p class="text-xs text-gray-500 mb-1">{{ $label }}</p>
      <a href="{{ asset('storage/'.$user->document->$field) }}" target="_blank" class="text-xs text-primary-600 hover:underline flex items-center gap-1"><i class="fas fa-file-alt"></i>View Document</a></div>
      @endif
      @endforeach
    </div>
    @endif
  </div>
  <div class="lg:col-span-2 space-y-5">
    <div class="grid grid-cols-3 gap-4">
      @foreach([['Total Bookings','fas fa-calendar-check',$user->providerBookings->count(),'bg-primary-100 text-primary-600'],['Total Services','fas fa-concierge-bell',$user->services->count(),'bg-purple-100 text-purple-600'],['Avg Rating','fas fa-star',number_format($user->reviews->avg('rating')??0,1),'bg-yellow-100 text-yellow-600']] as $s)
      <div class="card p-4 text-center"><div class="w-10 h-10 rounded-xl {{ $s[3] }} flex items-center justify-center mx-auto mb-2"><i class="{{ $s[1] }} text-sm"></i></div>
      <p class="text-xl font-bold text-gray-800 dark:text-white">{{ $s[2] }}</p><p class="text-xs text-gray-400">{{ $s[0] }}</p></div>
      @endforeach
    </div>
    <div class="card overflow-hidden">
      <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700"><h3 class="font-semibold text-sm text-gray-800 dark:text-white">Services</h3></div>
      <table class="data-table w-full">
        <thead><tr><th>Service</th><th>Category</th><th>Price</th><th>Bookings</th><th>Status</th></tr></thead>
        <tbody>
        @forelse($user->services as $s)
        <tr>
          <td><div class="flex items-center gap-2">@if($s->image)<img src="{{ asset('storage/'.$s->image) }}" class="w-8 h-8 rounded-lg object-cover">@endif<span class="text-sm font-medium">{{ $s->name }}</span></div></td>
          <td>
            <span class="text-xs text-gray-500">
                {{ $s->category->name ?? 'No Category' }}
            </span>
        </td>
          <td><span class="font-medium text-primary-600">${{ number_format($s->price,2) }}</span></td>
          <td><span class="badge badge-info">{{ $s->total_bookings }}</span></td>
          <td><span class="badge {{ $s->status==='active'?'badge-success':'badge-pending' }}">{{ ucfirst($s->status) }}</span></td>
        </tr>
        @empty<tr><td colspan="5" class="text-center py-6 text-gray-400 text-sm">No services</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
