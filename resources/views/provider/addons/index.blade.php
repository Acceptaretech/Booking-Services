@extends('layouts.provider.app')

@section('title','Addons')
@section('page_title','Addons')

@section('content')

<div class="card p-5 mb-6">
    <div class="flex justify-between items-center">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white">
            Addons
        </h2>

        <a href="{{ route('provider.addons.create') }}" class="btn-primary">
            <i class="fas fa-plus-circle mr-2"></i>
            New
        </a>
    </div>
</div>

<div class="card p-6">

    <form method="GET" action="{{ route('provider.addons.index') }}">
        <div class="flex flex-col lg:flex-row justify-between gap-4 mb-8">

            <div class="flex gap-4">

                <select form="bulkActionForm"
                        name="action"
                        class="form-select w-56">
                    <option value="">No Action</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="delete">Delete</option>
                </select>

                <button form="bulkActionForm"
                        type="submit"
                        class="btn-primary">
                    Apply
                </button>

            </div>

            <div class="flex gap-4">

                <select name="status"
                        class="form-select w-36"
                        onchange="this.form.submit()">
                    <option value="">All</option>
                    <option value="active"
                        {{ request('status')=='active' ? 'selected' : '' }}>
                        Active
                    </option>
                    <option value="inactive"
                        {{ request('status')=='inactive' ? 'selected' : '' }}>
                        Inactive
                    </option>
                </select>

                <div class="relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>

                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Search..."
                           class="form-input pl-11 w-64">
                </div>

            </div>

        </div>
    </form>

    <form id="bulkActionForm"
          method="POST"
          action="{{ route('provider.addons.bulk-action') }}">

        @csrf

        <div class="overflow-x-auto">

            <table class="data-table min-w-[1200px]">

                <thead>
                <tr>
                    <th width="50">
                        <input type="checkbox" id="checkAll">
                    </th>

                    <th>Name</th>
                    <th>Service</th>
                    <th>Provider</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th width="150">Action</th>
                </tr>
                </thead>

                <tbody>

                @forelse($addons as $addon)

                    <tr>

                        <td>
                            <input type="checkbox"
                                   name="ids[]"
                                   value="{{ $addon->id }}">
                        </td>

                        <td>
                            <div class="flex items-center gap-3">

                                <img src="{{ $addon->image_url ?? asset('images/default-service.png') }}"
                                     class="w-12 h-12 rounded-full object-cover">

                                <div>
                                    <div class="font-semibold">
                                        {{ $addon->name }}
                                    </div>

                                    @if($addon->description)
                                        <div class="text-xs text-gray-500">
                                            {{ \Illuminate\Support\Str::limit($addon->description,40) }}
                                        </div>
                                    @endif
                                </div>

                            </div>
                        </td>

                        <td>
                            {{ $addon->service->name ?? '-' }}
                        </td>

                        <td>
                            <div class="flex items-center gap-3">

                                <img src="{{ auth()->user()->profile_image_url ?? asset('images/default-user.png') }}"
                                     class="w-10 h-10 rounded-full object-cover">

                                <div>
                                    <div class="font-semibold">
                                        {{ auth()->user()->first_name ?? auth()->user()->name }}
                                    </div>

                                    <div class="text-sm text-gray-500">
                                        {{ auth()->user()->email }}
                                    </div>
                                </div>

                            </div>
                        </td>

                        <td>
                            ${{ number_format($addon->price,2) }}
                        </td>

                        <td>

                            <form action="{{ route('provider.addons.toggle',$addon->id) }}"
                                  method="POST">

                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                        class="relative inline-flex h-6 w-12 items-center rounded-full {{ $addon->status=='active' ? 'bg-primary-600' : 'bg-gray-300' }}">

                                    <span class="inline-block h-5 w-5 transform rounded-full bg-white transition {{ $addon->status=='active' ? 'translate-x-6' : 'translate-x-1' }}"></span>

                                </button>

                            </form>

                        </td>

                        <td>

                            <div class="flex items-center justify-center gap-4">

                                <a href="{{ route('provider.addons.edit',$addon->id) }}"
                                   class="text-gray-500 hover:text-primary-600">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>

                                <form action="{{ route('provider.addons.destroy',$addon->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Delete this addon?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="text-red-500 hover:text-red-700">
                                        <i class="far fa-trash-alt"></i>
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="text-center py-16 text-gray-400">
                            No data available in table
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </form>

    <div class="mt-6">
        {{ $addons->links() }}
    </div>

</div>

@endsection

@push('scripts')
<script>

document.getElementById('checkAll')?.addEventListener('change', function() {

    document.querySelectorAll('input[name="ids[]"]').forEach(item => {
        item.checked = this.checked;
    });

});

</script>
@endpush