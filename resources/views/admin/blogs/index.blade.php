@extends('layouts.admin.app')

@section('page_title','Blogs')

@section('content')
<div class="space-y-6">

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 flex items-center justify-between">
        <h2 class="text-xl font-bold text-gray-800 dark:text-white">Blogs</h2>

        <a href="{{ route('admin.blogs.create') }}"
           class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700">
            <i class="fas fa-plus-circle mr-1"></i> New
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
            <form method="GET" class="flex flex-col sm:flex-row gap-3">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search blogs..."
                       class="rounded-xl border-gray-300 dark:bg-gray-900 dark:text-white">

                <select name="status"
                        class="rounded-xl border-gray-300 dark:bg-gray-900 dark:text-white">
                    <option value="">All Status</option>
                    <option value="published" {{ request('status')=='published'?'selected':'' }}>Published</option>
                    <option value="draft" {{ request('status')=='draft'?'selected':'' }}>Draft</option>
                </select>

                <button class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white">
                    Search
                </button>
            </form>
        </div>

        <form method="POST" action="{{ route('admin.blogs.bulk') }}">
            @csrf

           {{--}} <div class="flex gap-3 mb-4">
                <select name="action" class="rounded-xl border-gray-300 dark:bg-gray-900 dark:text-white">
                    <option value="">Bulk Action</option>
                    <option value="delete">Delete</option>
                    <option value="published">Mark Published</option>
                    <option value="draft">Mark Draft</option>
                </select>

                <button class="px-5 py-2.5 rounded-xl bg-gray-800 text-white">
                    Apply
                </button>
            </div> --}} 

            <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
                <table class="w-full min-w-[1000px]">
                    <thead class="bg-indigo-600 text-white">
                        <tr>
                            <th class="p-4 text-left">
                                <input type="checkbox" id="selectAll">
                            </th>
                            <th class="p-4 text-left">Title</th>
                            <th class="p-4 text-left">Author</th>
                            <th class="p-4 text-left">Views</th>
                            <th class="p-4 text-left">Read Time</th>
                            <th class="p-4 text-left">Status</th>
                            <th class="p-4 text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($blogs as $blog)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-900">
                                <td class="p-4">
                                    <input type="checkbox" name="ids[]" value="{{ $blog->id }}" class="rowCheck">
                                </td>

                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $blog->image ? asset('storage/'.$blog->image) : asset('assets/admin/img/placeholder.png') }}"
                                             class="w-12 h-12 rounded-full object-cover">

                                        <div>
                                            <p class="font-semibold text-indigo-600">{{ $blog->title }}</p>
                                            <p class="text-xs text-gray-500">{{ $blog->slug }}</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="p-4">
                                  <p class="font-semibold text-gray-800 dark:text-white">
                                      {{ $blog->author ? $blog->author->first_name . ' ' . $blog->author->last_name : 'No Author' }}
                                  </p>
                              
                                  <p class="text-sm text-gray-500">
                                      {{ $blog->author->email ?? '-' }}
                                  </p>
                              </td>

                                <td class="p-4 text-gray-700 dark:text-gray-300">
                                    {{ $blog->views ?? 0 }}
                                </td>

                                <td class="p-4 text-gray-700 dark:text-gray-300">
                                    {{ $blog->read_time ?? 0 }} min
                                </td>

                                <td class="p-4">
                                    <form method="POST" action="{{ route('admin.blogs.toggle', $blog->id) }}">
                                        @csrf
                                        @method('PATCH')

                                        <button type="submit"
                                            class="px-4 py-1.5 rounded-full text-sm font-semibold
                                            {{ $blog->status == 'published'
                                                ? 'bg-green-100 text-green-700'
                                                : 'bg-yellow-100 text-yellow-700' }}">
                                            {{ ucfirst($blog->status) }}
                                        </button>
                                    </form>
                                </td>

                                <td class="p-4 text-center">
                                    <a href="{{ route('admin.blogs.edit', $blog->id) }}"
                                       class="text-indigo-600 hover:text-indigo-800 mr-3">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form method="POST" action="{{ route('admin.blogs.destroy', $blog->id) }}"
                                          class="inline-block">
                                        @csrf
                                        @method('DELETE')

                                        <button onclick="return confirm('Delete this blog?')"
                                                class="text-red-600 hover:text-red-800">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-gray-500">
                                    No blogs found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        <div class="mt-6">
            {{ $blogs->links() }}
        </div>

    </div>
</div>

<script>
document.getElementById('selectAll')?.addEventListener('change', function () {
    document.querySelectorAll('.rowCheck').forEach(cb => cb.checked = this.checked);
});
</script>
@endsection