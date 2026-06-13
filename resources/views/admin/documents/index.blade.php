@extends('layouts.admin.app')

@section('page_title', 'Document List')

@section('content')
<div class="space-y-8">

    <div class="card flex items-center justify-between p-6">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white">Document List</h2>

        <a href="{{ route('admin.documents.create') }}" class="btn-primary">
            <i class="fas fa-plus-circle mr-1"></i> New
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-lg bg-green-100 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="card p-6">
        <form method="GET" class="flex flex-wrap justify-between gap-4 mb-8">
            <div class="flex gap-3">
                <select class="form-input w-56">
                    <option>No Action</option>
                </select>

                <button type="button" class="btn-primary">Apply</button>
            </div>

            <div class="flex gap-4">
                <select name="type" class="form-input w-36" onchange="this.form.submit()">
                    <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>All</option>
                    <option value="provider" {{ request('type') == 'provider' ? 'selected' : '' }}>Provider</option>
                    <option value="shop" {{ request('type') == 'shop' ? 'selected' : '' }}>Shop</option>
                </select>

                <div class="relative">
                    <i class="fas fa-search absolute left-4 top-4 text-gray-500"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search..."
                           class="form-input pl-11 w-56">
                </div>
            </div>
        </form>

        <div class="overflow-x-auto rounded-t-xl">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-indigo-600 text-white">
                        <th class="px-6 py-5 text-left">
                            <input type="checkbox" class="rounded">
                        </th>
                        <th class="px-6 py-5 text-left">Name</th>
                        <th class="px-6 py-5 text-left">Document Type</th>
                        <th class="px-6 py-5 text-left">Required</th>
                        <th class="px-6 py-5 text-left">Status</th>
                        <th class="px-6 py-5 text-left">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($documents as $document)
                        <tr class="border-b dark:border-gray-700 odd:bg-gray-50 dark:odd:bg-gray-800">
                            <td class="px-6 py-5">
                                <input type="checkbox" class="rounded">
                            </td>

                            <td class="px-6 py-5">
                                <a href="{{ route('admin.documents.edit', $document->id) }}"
                                   class="text-indigo-600 hover:underline">
                                    {{ $document->name }}
                                </a>
                            </td>

                            <td class="px-6 py-5 text-gray-700 dark:text-gray-200">
                                {{ $document->document_type === 'provider' ? 'Provider Document' : 'Shop Document' }}
                            </td>

                            <td class="px-6 py-5">
                                <form method="POST" action="{{ route('admin.documents.toggleRequired', $document->id) }}">
                                    @csrf
                                    @method('PATCH')

                                    <button class="relative inline-flex h-6 w-12 rounded-full {{ $document->is_required ? 'bg-indigo-600' : 'bg-gray-300' }}">
                                        <span class="inline-block h-5 w-5 transform rounded-full bg-white transition mt-0.5 {{ $document->is_required ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                    </button>
                                </form>
                            </td>

                            <td class="px-6 py-5">
                                <form method="POST" action="{{ route('admin.documents.toggleStatus', $document->id) }}">
                                    @csrf
                                    @method('PATCH')

                                    <button class="relative inline-flex h-6 w-12 rounded-full {{ $document->status === 'active' ? 'bg-indigo-600' : 'bg-gray-300' }}">
                                        <span class="inline-block h-5 w-5 transform rounded-full bg-white transition mt-0.5 {{ $document->status === 'active' ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                    </button>
                                </form>
                            </td>

                            <td class="px-6 py-5">
                                <form method="POST" action="{{ route('admin.documents.destroy', $document->id) }}"
                                      onsubmit="return confirm('Delete this document?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                No documents found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $documents->links() }}
        </div>
    </div>
</div>
@endsection