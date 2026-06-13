@extends('layouts.admin.app')
@section('title','Reports')
@section('page_title','Reports & Analytics')
@section('content')
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
  @foreach([['Total Revenue','fas fa-chart-line','$'.number_format($stats['total_revenue'],2),'from-primary-500 to-purple-600'],
            ['Admin Commission','fas fa-percent','$'.number_format($stats['total_commission'],2),'from-blue-500 to-cyan-500'],
            ['Total Bookings','fas fa-calendar-check',$stats['total_bookings'],'from-emerald-500 to-teal-500'],
            ['Total Providers','fas fa-user-tie',$stats['total_providers'],'from-orange-500 to-rose-500']] as $s)
  <div class="card p-4 flex items-center gap-3">
    <div class="w-10 h-10 rounded-xl bg-gradient-to-br {{ $s[3] }} flex items-center justify-center flex-shrink-0"><i class="{{ $s[1] }} text-white text-sm"></i></div>
    <div><p class="font-bold text-gray-800 dark:text-white text-lg">{{ $s[2] }}</p><p class="text-xs text-gray-400">{{ $s[0] }}</p></div>
  </div>
  @endforeach
</div>
<div class="card p-5 mb-6">
  <h3 class="font-semibold text-gray-800 dark:text-white mb-4">Monthly Revenue — {{ $year }}</h3>
  <canvas id="reportChart" height="120"></canvas>
</div>
<div class="card overflow-hidden">
  <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700"><h3 class="font-semibold text-sm text-gray-800 dark:text-white">Monthly Breakdown</h3></div>
  <table class="data-table w-full">
    <thead><tr><th>Month</th><th>Total Revenue</th><th>Admin Earning</th><th>Bookings</th></tr></thead>
    <tbody>
    @foreach(['January','February','March','April','May','June','July','August','September','October','November','December'] as $mi => $month)
    @php $row = $monthlyRevenue->get($mi+1); @endphp
    <tr>
      <td><span class="font-medium text-sm text-gray-800 dark:text-gray-200">{{ $month }}</span></td>
      <td><span class="font-semibold text-primary-600">${{ number_format($row?->total ?? 0,2) }}</span></td>
      <td><span class="text-emerald-600">${{ number_format($row?->admin_earn ?? 0,2) }}</span></td>
      <td><span class="badge badge-info">—</span></td>
    </tr>
    @endforeach
    </tbody>
  </table>
</div>
@endsection
@push('scripts')
<script>
const months=['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
const data=@json($monthlyRevenue->pluck('total')->values()->toArray());
const ctx=document.getElementById('reportChart');
new Chart(ctx,{type:'bar',data:{labels:months,datasets:[{label:'Revenue ($)',data:data,backgroundColor:'rgba(99,102,241,.7)',borderRadius:8,borderSkipped:false}]},options:{responsive:true,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,ticks:{callback:v=>'$'+v}},x:{grid:{display:false}}}}});
</script>
@endpush
